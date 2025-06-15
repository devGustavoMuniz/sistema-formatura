<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import InputError from '@/Components/InputError.vue';

// 1. Defina a prop 'institutes' para receber a lista do controller
const props = defineProps({
    institutes: {
        type: Array,
        required: true,
    }
});

// 2. O formulário já contém os campos corretos
const form = useForm({
    name: '',
    ra: '',
    email: '',
    institute_id: null,
});

// 3. A função submit agora envia os dados para a rota 'store'
const submit = () => {
    form.post(route('admin.students.store'), {
        onSuccess: () => {
            // O formulário é limpo automaticamente em caso de sucesso
        }
    });
};
</script>

<template>
    <Head title="Novo Aluno" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Cadastrar Novo Aluno
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="max-w-2xl mx-auto">
                    <CardHeader>
                        <CardTitle>Dados do Aluno</CardTitle>
                        <CardDescription>Preencha os campos para cadastrar um novo aluno.</CardDescription>
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
                                    <Button type="submit" :disabled="form.processing">Salvar Aluno</Button>
                                </div>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
