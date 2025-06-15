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
    cnpj: '',
    address: '',
});

const submit = () => {
    // A lógica de submit virá aqui
    // form.post(route('admin.institutes.store'));
    console.log(form.data());
};
</script>

<template>
    <Head title="Nova Instituição" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Cadastrar Nova Instituição
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="max-w-2xl mx-auto">
                    <CardHeader>
                        <CardTitle>Dados da Instituição</CardTitle>
                        <CardDescription>Preencha os campos abaixo para cadastrar uma nova instituição.</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit">
                            <div class="grid gap-4">
                                <div class="grid gap-2">
                                    <Label for="name">Nome da Instituição</Label>
                                    <Input id="name" type="text" v-model="form.name" required />
                                    <InputError :message="form.errors.name" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="cnpj">CNPJ</Label>
                                    <Input id="cnpj" type="text" v-model="form.cnpj" required />
                                    <InputError :message="form.errors.cnpj" />
                                </div>
                                <div class="grid gap-2">
                                    <Label for="address">Endereço</Label>
                                    <Input id="address" type="text" v-model="form.address" />
                                    <InputError :message="form.errors.address" />
                                </div>
                                <div class="flex justify-end gap-2 mt-4">
                                     <Link :href="route('admin.institutes.index')">
                                        <Button variant="outline">Cancelar</Button>
                                    </Link>
                                    <Button type="submit" :disabled="form.processing">Salvar</Button>
                                </div>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
