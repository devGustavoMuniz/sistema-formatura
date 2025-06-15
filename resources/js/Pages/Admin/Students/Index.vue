<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { debounce } from 'lodash';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { MoreHorizontal, Search } from 'lucide-vue-next';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    students: Object,
    allInstitutes: Array,
    filters: {
        type: Object,
        default: () => ({ search: '', institute_id: 'all' }),
    },
});

const filters = ref({
    search: props.filters.search,
    institute_id: props.filters.institute_id || 'all',
});

// 1. Crie refs para controlar o modal de exclusão do aluno
const confirmingDelete = ref(false);
const studentToDelete = ref(null);

// 2. Crie funções para cada ação do menu
const viewStudent = (id) => {
    router.get(route('admin.students.show', id));
};

const editStudent = (id) => {
    router.get(route('admin.students.edit', id));
};

const confirmDelete = (student) => {
    studentToDelete.value = student;
    confirmingDelete.value = true;
};

const deleteStudent = () => {
    if (studentToDelete.value) {
        router.delete(route('admin.students.destroy', studentToDelete.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                confirmingDelete.value = false;
                studentToDelete.value = null;
            },
        });
    }
};

watch(filters, debounce(() => {
    router.get(route('admin.students.index'), filters.value, {
        preserveState: true,
        replace: true,
    });
}, 300), { deep: true });

</script>

<template>
    <Head title="Gerenciar Alunos" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Gerenciamento de Alunos
                </h2>
                <Link :href="route('admin.students.create')">
                <Button>Novo Aluno</Button>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Lista de Alunos</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="relative w-full max-w-sm">
                                <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                                <Input type="search" placeholder="Buscar por nome ou RA..." class="pl-9" v-model="filters.search" />
                            </div>
                            <Select v-model="filters.institute_id">
                                <SelectTrigger class="w-[280px]">
                                    <SelectValue placeholder="Filtrar por instituição" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Instituições</SelectLabel>
                                        <SelectItem value="all">Todas as Instituições</SelectItem>
                                        <SelectItem v-for="institute in allInstitutes" :key="institute.id" :value="institute.id.toString()">
                                            {{ institute.name }}
                                        </SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nome do Aluno</TableHead>
                                    <TableHead>RA</TableHead>
                                    <TableHead>Instituição</TableHead>
                                    <TableHead class="text-right">Ações</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="student in students.data" :key="student.id">
                                    <TableCell class="font-medium">{{ student.name }}</TableCell>
                                    <TableCell>{{ student.ra }}</TableCell>
                                    <TableCell>{{ student.institute.name }}</TableCell>
                                    <TableCell class="text-right">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger as-child>
                                                <Button variant="ghost" class="h-8 w-8 p-0">
                                                    <span class="sr-only">Abrir menu</span>
                                                    <MoreHorizontal class="h-4 w-4" />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="end">
                                                <DropdownMenuItem @select="viewStudent(student.id)">
                                                    Ver Detalhes
                                                </DropdownMenuItem>
                                                <DropdownMenuItem @select="editStudent(student.id)">
                                                    Editar
                                                </DropdownMenuItem>
                                                <DropdownMenuItem @select="confirmDelete(student)">
                                                    Excluir
                                                </DropdownMenuItem>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>

                        <Pagination class="mt-6" :links="students.links" />
                    </CardContent>
                </Card>
            </div>
        </div>

        <AlertDialog :open="confirmingDelete" @update:open="confirmingDelete = false">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Você tem certeza?</AlertDialogTitle>
                    <AlertDialogDescription>
                        Essa ação não pode ser desfeita. Isso irá deletar permanentemente o aluno
                        <span v-if="studentToDelete" class="font-bold">{{ studentToDelete.name }}</span> e todas as suas fotos.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="confirmingDelete = false">Cancelar</AlertDialogCancel>
                    <AlertDialogAction @click="deleteStudent">Confirmar Exclusão</AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

    </AuthenticatedLayout>
</template>