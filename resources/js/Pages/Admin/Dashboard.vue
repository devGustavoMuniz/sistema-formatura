<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Users, School } from 'lucide-vue-next';

// 1. Defina a prop 'stats' que o controller está enviando.
defineProps({
    stats: {
        type: Object,
        required: true,
    }
});
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard do Administrador
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <Link :href="route('admin.students.index')">
                        <Card>
                        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle class="text-sm font-medium">
                                Total de Alunos
                            </CardTitle>
                            <Users class="h-4 w-4 text-muted-foreground" />
                        </CardHeader>
                        <CardContent>
                            <div class="text-2xl font-bold">
                                {{ stats.students }}
                            </div>
                            <p class="text-xs text-muted-foreground">
                                Clique para gerenciar
                            </p>
                        </CardContent>
                    </Card>
                    </Link>
                     <Link :href="route('admin.institutes.index')">
                        <Card class="hover:bg-accent transition-colors">
                            <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                                <CardTitle class="text-sm font-medium">
                                    Total de Instituições
                                </CardTitle>
                                <School class="h-4 w-4 text-muted-foreground" />
                            </CardHeader>
                            <CardContent>
                                <div class="text-2xl font-bold">
                                    {{ stats.institutes }}
                                </div>
                                <p class="text-xs text-muted-foreground">
                                    Clique para gerenciar
                                </p>
                            </CardContent>
                        </Card>
                    </Link>
                </div>

                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium">Atividade Recente</h3>
                        <p class="mt-4">Aqui você pode adicionar um gráfico ou uma lista de atividades recentes.</p>
                        <div class="mt-4 h-64 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500">Gráfico de Atividade</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>