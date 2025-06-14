<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog';
import { Input } from '@/components/ui/input';
import { Select, SelectContent, SelectGroup, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { MoreHorizontal, Search } from 'lucide-vue-next';

// Dados mocados para visualização
const students = ref([
    { id: 1, name: 'Gustavo Muniz', ra: '202010140', institution: 'Universidade Federal de Lavras' },
    { id: 2, name: 'Maria Silva', ra: '202120315', institution: 'Centro Universitário de Lavras' },
    { id: 3, name: 'João Pereira', ra: '201910042', institution: 'Universidade Federal de Lavras' },
]);
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
                        <!-- Filtros -->
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="relative w-full max-w-sm">
                                <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                                <Input type="search" placeholder="Buscar por nome ou RA..." class="pl-9" />
                            </div>
                            <Select>
                                <SelectTrigger class="w-[280px]">
                                    <SelectValue placeholder="Filtrar por instituição" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Instituições</SelectLabel>
                                        <SelectItem value="all">Todas as Instituições</SelectItem>
                                        <SelectItem value="ufla">Universidade Federal de Lavras</SelectItem>
                                        <SelectItem value="unilavras">Centro Universitário de Lavras</SelectItem>
                                        <SelectItem value="gammon">Instituto Presbiteriano Gammon</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                        <!-- Tabela de Alunos -->
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
                                <TableRow v-for="student in students" :key="student.id">
                                    <TableCell class="font-medium">{{ student.name }}</TableCell>
                                    <TableCell>{{ student.ra }}</TableCell>
                                    <TableCell>{{ student.institution }}</TableCell>
                                    <TableCell class="text-right">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger as-child>
                                                <Button variant="ghost" class="h-8 w-8 p-0">
                                                    <span class="sr-only">Abrir menu</span>
                                                    <MoreHorizontal class="h-4 w-4" />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="end">
                                                <Link :href="route('admin.students.show', student.id)">
                                                <DropdownMenuItem>Ver Detalhes</DropdownMenuItem>
                                                </Link>
                                                <Link :href="route('admin.students.edit', student.id)">
                                                <DropdownMenuItem>Editar</DropdownMenuItem>
                                                </Link>
                                                <AlertDialog>
                                                    <AlertDialogTrigger as-child>
                                                        <DropdownMenuItem @select.prevent>Excluir</DropdownMenuItem>
                                                    </AlertDialogTrigger>
                                                    <AlertDialogContent>
                                                        <AlertDialogHeader>
                                                            <AlertDialogTitle>Você tem certeza?</AlertDialogTitle>
                                                            <AlertDialogDescription>
                                                                Essa ação não pode ser desfeita. Isso irá deletar
                                                                permanentemente o aluno e suas fotos.
                                                            </AlertDialogDescription>
                                                        </AlertDialogHeader>
                                                        <AlertDialogFooter>
                                                            <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                                            <AlertDialogAction>Confirmar</AlertDialogAction>
                                                        </AlertDialogFooter>
                                                    </AlertDialogContent>
                                                </AlertDialog>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
