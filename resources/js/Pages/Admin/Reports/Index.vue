<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

const props = defineProps({
    reportData: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({}),
    }
});

// O estado do formulário de filtros, sincronizado com a prop do Inertia
const selectedReport = ref(props.filters.report_type || null);

// Verifica se o relatório deve ser exibido
const reportGenerated = computed(() => props.reportData && props.reportData.length > 0);

// Propriedade computada para definir o título do relatório dinamicamente
const reportTitle = computed(() => {
    if (props.filters.report_type === 'students_by_institution') {
        return 'Resultado: Alunos por Instituição';
    }
    if (props.filters.report_type === 'photos_by_student') {
        return 'Resultado: Fotos por Aluno';
    }
    return '';
});


// Função que submete os filtros para o backend
function generateReport() {
    if (selectedReport.value) {
        router.get(route('admin.reports.index'), {
            report_type: selectedReport.value
        }, {
            preserveState: true,
            replace: true,
        });
    } else {
        alert('Por favor, selecione um tipo de relatório.');
    }
}
</script>

<template>
    <Head title="Relatórios" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Relatórios Gerenciais
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card>
                    <CardHeader>
                        <CardTitle>Gerador de Relatórios</CardTitle>
                        <CardDescription>Selecione o tipo de relatório que deseja visualizar e clique em "Gerar".</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <!-- Controles do Relatório -->
                        <div class="flex items-center space-x-4 mb-6">
                            <Select v-model="selectedReport">
                                <SelectTrigger class="w-[320px]">
                                    <SelectValue placeholder="Selecione o tipo de relatório" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectItem value="students_by_institution">Alunos por Instituição</SelectItem>
                                        <SelectItem value="photos_by_student">Fotos por Aluno</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <Button @click="generateReport">Gerar Relatório</Button>
                        </div>

                        <!-- Tabela de Resultados Dinâmica -->
                        <div v-if="reportGenerated">
                            <h3 class="text-lg font-medium mb-4 mt-8">{{ reportTitle }}</h3>

                            <!-- Tabela: Alunos por Instituição -->
                            <Table v-if="filters.report_type === 'students_by_institution'">
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Instituição</TableHead>
                                        <TableHead class="text-right">Total de Alunos</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow v-for="item in reportData" :key="`institute-${item.id}`">
                                        <TableCell class="font-medium">{{ item.name }}</TableCell>
                                        <TableCell class="text-right">{{ item.students_count }}</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>

                            <!-- Tabela: Fotos por Aluno -->
                            <Table v-if="filters.report_type === 'photos_by_student'">
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Aluno</TableHead>
                                        <TableHead class="text-right">Total de Fotos</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow v-for="item in reportData" :key="`student-${item.id}`">
                                        <TableCell class="font-medium">{{ item.name }}</TableCell>
                                        <TableCell class="text-right">{{ item.photos_count }}</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
