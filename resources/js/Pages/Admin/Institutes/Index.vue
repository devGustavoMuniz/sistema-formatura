<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue'; // Importar ref e watch
import { debounce } from 'lodash'; // Importar debounce para otimização
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog';
import { Input } from '@/components/ui/input'; // Importar o componente de Input
import { MoreHorizontal, Search } from 'lucide-vue-next';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    institutes: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
});

// Lógica para o campo de busca
const search = ref(props.filters.search);
watch(search, debounce((value) => {
    router.get(route('admin.institutes.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
}, 300));


const deleteInstitute = (id) => {
    router.delete(route('admin.institutes.destroy', id), {
        preserveScroll: true,
    });
};

</script>

<template>
    <Head title="Gerenciar Instituições" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Gerenciamento de Instituições
                </h2>
                <Link :href="route('admin.institutes.create')">
                    <Button>Nova Instituição</Button>
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Lista de Instituições</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <!-- CAMPO DE BUSCA ADICIONADO AQUI -->
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="relative w-full max-w-sm">
                                <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
                                <Input
                                    type="search"
                                    placeholder="Buscar por nome ou CNPJ..."
                                    class="pl-9"
                                    v-model="search"
                                />
                            </div>
                        </div>

                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nome</TableHead>
                                    <TableHead>CNPJ</TableHead>
                                    <TableHead>Endereço</TableHead>
                                    <TableHead class="text-right">Ações</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="inst in institutes.data" :key="inst.id">
                                    <TableCell class="font-medium">{{ inst.name }}</TableCell>
                                    <TableCell>{{ inst.cnpj }}</TableCell>
                                    <TableCell>{{ inst.address }}</TableCell>
                                    <TableCell class="text-right">
                                        <DropdownMenu>
                                            <DropdownMenuTrigger as-child>
                                                <Button variant="ghost" class="h-8 w-8 p-0">
                                                    <span class="sr-only">Abrir menu</span>
                                                    <MoreHorizontal class="h-4 w-4" />
                                                </Button>
                                            </DropdownMenuTrigger>
                                            <DropdownMenuContent align="end">
                                                <Link :href="route('admin.institutes.edit', inst.id)">
                                                    <DropdownMenuItem>Editar</DropdownMenuItem>
                                                </Link>
                                                <AlertDialog>
                                                    <AlertDialogTrigger as-child>
                                                        <DropdownMenuItem @select.prevent>
                                                            Excluir
                                                        </DropdownMenuItem>
                                                    </AlertDialogTrigger>
                                                    <AlertDialogContent>
                                                        <AlertDialogHeader>
                                                            <AlertDialogTitle>Você tem certeza?</AlertDialogTitle>
                                                            <AlertDialogDescription>
                                                                Essa ação não pode ser desfeita. Isso irá deletar permanentemente a instituição.
                                                            </AlertDialogDescription>
                                                        </AlertDialogHeader>
                                                        <AlertDialogFooter>
                                                            <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                                            <AlertDialogAction @click="deleteInstitute(inst.id)">Confirmar</AlertDialogAction>
                                                        </AlertDialogFooter>
                                                    </AlertDialogContent>
                                                </AlertDialog>
                                            </DropdownMenuContent>
                                        </DropdownMenu>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>

                        <Pagination class="mt-6" :links="institutes.links" />

                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
