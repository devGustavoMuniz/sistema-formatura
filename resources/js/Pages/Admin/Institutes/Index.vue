<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { MoreHorizontal } from 'lucide-vue-next';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog';

// Dados mocados para visualização
const institutions = [
  { id: 1, name: 'Universidade Federal de Lavras', cnpj: '26.196.838/0001-20', address: 'Campus Universitário, Lavras - MG' },
  { id: 2, name: 'Centro Universitário de Lavras', cnpj: '12.345.678/0001-99', address: 'Rua de Exemplo, 123, Lavras - MG' },
  { id: 3, name: 'Instituto Presbiteriano Gammon', cnpj: '98.765.432/0001-11', address: 'Praça Dr. Augusto Silva, 772, Lavras - MG' },
];

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
                                <TableRow v-for="inst in institutions" :key="inst.id">
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
                                                        <!-- 
                                                            CORREÇÃO: Adicionado @select.prevent
                                                            Isso impede que o clique no item feche o DropdownMenu,
                                                            permitindo que o AlertDialog permaneça visível.
                                                        -->
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
