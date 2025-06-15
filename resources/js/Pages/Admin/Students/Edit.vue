<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    student: {
        type: Object,
        required: true,
    },
    institutes: {
        type: Array,
        required: true,
    }
});
const form = useForm({
    name: props.student.name,
    ra: props.student.ra,
    user_id: props.student.user_id,
    institute_id: props.student.institute_id.toString(),
});

const submit = () => {
    form.put(route('admin.students.update', props.student.id));
};
</script>

<template>
    <Head title="Editar Aluno" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Aluno: {{ student.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="max-w-2xl mx-auto">
                    <CardHeader>
                        <CardTitle>Dados do Aluno</CardTitle>
                        <CardDescription>Altere os campos para atualizar os dados do aluno.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit">
                            <div class="grid gap-4">
                                <div class="grid gap-2">
                                    <Label for="name">Nome Completo</Label>
                                    <Input id="name" type="text" v-model="form.name" required />
                                    <InputError :message="form.errors.name" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="ra">RA (Registro Acadêmico)</Label>
                                    <Input id="ra" type="text" v-model="form.ra" required />
                                    <InputError :message="form.errors.ra" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="institute">Instituição</Label>
                                      <Select v-model="form.institute_id">
                                        <SelectTrigger>
                                            <SelectValue placeholder="Selecione uma instituição" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectItem v-for="institute in institutes" :key="institute.id" :value="institute.id.toString()">
                                                    {{ institute.name }}
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                    <InputError :message="form.errors.institute_id" />
                                </div>
                                <div class="flex justify-end gap-2 mt-4">
                                     <Link :href="route('admin.students.index')">
                                        <Button variant="outline">Cancelar</Button>
                                    </Link>
                                    <Button type="submit" :disabled="form.processing">Atualizar Aluno</Button>
                                </div>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>