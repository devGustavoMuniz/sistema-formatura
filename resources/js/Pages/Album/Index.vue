<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Card, CardContent } from '@/components/ui/card';

// As fotos são passadas como uma prop pelo AlbumController
const props = defineProps({
    photos: {
        type: Array,
        required: true,
    },
});

// Estado para controlar o modal
const isModalOpen = ref(false);
const selectedPhotoUrl = ref('');

// Função para construir o URL completo da imagem a partir do caminho do storage
const getPhotoUrl = (path) => {
    return `/storage/${path}`;
};

// Função para abrir o modal com a foto selecionada
const openModal = (photoPath) => {
    selectedPhotoUrl.value = getPhotoUrl(photoPath);
    isModalOpen.value = true;
};

// Função para fechar o modal
const closeModal = () => {
    isModalOpen.value = false;
    selectedPhotoUrl.value = '';
};
</script>

<template>
    <Head title="Meu Álbum" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Meu Álbum de Formatura
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Mensagem caso o aluno não tenha fotos -->
                <div v-if="photos.length === 0" class="text-center">
                    <Card class="py-10">
                        <CardContent>
                            <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">Nenhuma foto encontrada.</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                O seu álbum ainda está vazio. As fotos aparecerão aqui assim que forem adicionadas pelo administrador.
                            </p>
                        </CardContent>
                    </Card>
                </div>

                <!-- Galeria de Fotos -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div v-for="photo in photos" :key="photo.id" @click="openModal(photo.path)" class="cursor-pointer">
                        <Card class="overflow-hidden group">
                            <CardContent class="p-0">
                                <img
                                    :src="getPhotoUrl(photo.path)"
                                    alt="Foto do álbum"
                                    class="aspect-square w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    loading="lazy"
                                />
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para expandir a foto -->
        <div v-if="isModalOpen" @click.self="closeModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4 transition-opacity duration-300">
            <div class="relative max-w-4xl max-h-full">
                <img :src="selectedPhotoUrl" alt="Foto expandida" class="rounded-lg shadow-2xl max-h-[90vh]" />
                <button @click="closeModal" class="absolute -top-4 -right-4 bg-white rounded-full p-1 text-gray-800 hover:bg-gray-200 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
