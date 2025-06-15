<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/Components/InputError.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('admin.admins.store'));
};
</script>

<template>
    <Head title="Novo Administrador" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Cadastrar Novo Administrador
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="max-w-2xl mx-auto">
                    <CardHeader>
                        <CardTitle>Dados do Administrador</CardTitle>
                        <CardDescription>Preencha os campos para cadastrar um novo administrador.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit" class="grid gap-4">
                            <div class="grid gap-2">
                                <Label for="name">Nome</Label>
                                <Input id="name" type="text" v-model="form.name" required />
                                <InputError :message="form.errors.name" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="email">Email</Label>
                                <Input id="email" type="email" v-model="form.email" required />
                                <InputError :message="form.errors.email" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="password">Senha</Label>
                                <Input id="password" type="password" v-model="form.password" required />
                                <InputError :message="form.errors.password" />
                            </div>
                            <div class="grid gap-2">
                                <Label for="password_confirmation">Confirmar Senha</Label>
                                <Input id="password_confirmation" type="password" v-model="form.password_confirmation" required />
                                <InputError :message="form.errors.password_confirmation" />
                            </div>
                            <div class="flex justify-end gap-2 mt-4">
                                <Link :href="route('admin.admins.index')">
                                    <Button variant="outline">Cancelar</Button>
                                </Link>
                                <Button type="submit" :disabled="form.processing">Salvar</Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
