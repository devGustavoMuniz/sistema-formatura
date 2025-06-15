<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Input } from '@/components/ui/input';
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import Pagination from '@/Components/Pagination.vue'; // Supondo que você tenha um componente de paginação

const props = defineProps({
    admins: Object,
    filters: Object,
});

const search = ref(props.filters.search);
const showDeleteConfirmation = ref(false);
const adminToDelete = ref(null);

watch(search, value => {
    router.get(route('admin.admins.index'), { search: value }, {
        preserveState: true,
        replace: true,
    });
});

const confirmDelete = (admin) => {
    adminToDelete.value = admin;
    showDeleteConfirmation.value = true;
};

const deleteAdmin = () => {
    if (adminToDelete.value) {
        router.delete(route('admin.admins.destroy', adminToDelete.value.id), {
            onFinish: () => {
                showDeleteConfirmation.value = false;
                adminToDelete.value = null;
            }
        });
    }
};
</script>

<template>
    <Head title="Administradores" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Gestão de Administradores
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Administradores</CardTitle>
                        <CardDescription>Liste, crie e remova administradores do sistema.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="flex justify-between items-center mb-4">
                            <Input class="max-w-sm" placeholder="Filtrar por nome ou email..." v-model="search" />
                            <Link :href="route('admin.admins.create')">
                                <Button>Novo Administrador</Button>
                            </Link>
                        </div>
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Nome</TableHead>
                                    <TableHead>Email</TableHead>
                                    <TableHead class="text-right">Ações</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="admin in admins.data" :key="admin.id">
                                    <TableCell class="font-medium">{{ admin.name }}</TableCell>
                                    <TableCell>{{ admin.email }}</TableCell>
                                    <TableCell class="text-right">
                                        <Button variant="destructive" @click="confirmDelete(admin)">Excluir</Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                        <Pagination class="mt-6" :links="admins.links" />
                    </CardContent>
                </Card>
            </div>
        </div>

        <AlertDialog :open="showDeleteConfirmation">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Tem a certeza?</AlertDialogTitle>
                    <AlertDialogDescription>
                        Esta ação não pode ser desfeita. Isto irá remover permanentemente o administrador
                        <span class="font-bold">{{ adminToDelete?.name }}</span>.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="showDeleteConfirmation = false">Cancelar</AlertDialogCancel>
                    <AlertDialogAction @click="deleteAdmin">Confirmar</AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>

    </AuthenticatedLayout>
</template>
