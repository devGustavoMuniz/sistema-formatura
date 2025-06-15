<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import InputError from '@/Components/InputError.vue';

// No cenário real, os dados viriam como props da página.
const props = defineProps({
    student: {
        type: Object,
        default: () => ({
            id: 1,
            name: 'Gustavo Muniz',
            ra: '202010140',
            email: 'gustavo@exemplo.com',
            institute_id: '1' // ID correspondente à UFLA, por exemplo
        })
    }
});

const form = useForm({
    name: props.student.name,
    ra: props.student.ra,
    email: props.student.email,
    institute_id: props.student.institute_id,
});

const submit = () => {
    // Lógica de atualização viria aqui
    // form.put(route('admin.students.update', props.student.id));
    console.log(form.data());
};
</script>

<template>
    <Head title="Editar Aluno" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Editar Aluno
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
                                    <Label for="email">Email</Label>
                                    <Input id="email" type="email" v-model="form.email" required />
                                    <InputError :message="form.errors.email" />
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
                                                <SelectItem value="1">Universidade Federal de Lavras</SelectItem>
                                                <SelectItem value="2">Centro Universitário de Lavras</SelectItem>
                                                <SelectItem value="3">Instituto Presbiteriano Gammon</SelectItem>
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