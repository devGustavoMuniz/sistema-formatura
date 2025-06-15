<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

// Estado para controlar a exibição do relatório
const reportGenerated = ref(false);
const selectedReport = ref(null);

// Dados mocados para o relatório
const reportData = ref([
    { institution: 'Universidade Federal de Lavras', student_count: 350 },
    { institution: 'Centro Universitário de Lavras', student_count: 280 },
    { institution: 'Instituto Presbiteriano Gammon', student_count: 150 },
]);

// Função para simular a geração do relatório
function generateReport() {
    if (selectedReport.value) {
        console.log(`Gerando relatório: ${selectedReport.value}`);
        reportGenerated.value = true;
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
                                        <SelectItem value="photos_by_student" disabled>Fotos por Aluno (em breve)</SelectItem>
                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                            <Button @click="generateReport">Gerar Relatório</Button>
                        </div>

                        <!-- Tabela de Resultados -->
                        <div v-if="reportGenerated">
                             <h3 class="text-lg font-medium mb-4 mt-8">Resultado: Alunos por Instituição</h3>
                             <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Instituição</TableHead>
                                        <TableHead class="text-right">Total de Alunos</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <TableRow v-for="item in reportData" :key="item.institution">
                                        <TableCell class="font-medium">{{ item.institution }}</TableCell>
                                        <TableCell class="text-right">{{ item.student_count }}</TableCell>
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
