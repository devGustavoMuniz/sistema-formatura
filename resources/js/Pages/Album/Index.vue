<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Card, CardContent } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';

// Dados mocados para o álbum do aluno
const albumPhotos = ref([
  { id: 1, url: 'https://placehold.co/600x400/e2e8f0/64748b?text=Formatura+1' },
  { id: 2, url: 'https://placehold.co/600x400/cbd5e1/475569?text=Formatura+2' },
  { id: 3, url: 'https://placehold.co/600x400/94a3b8/1e293b?text=Formatura+3' },
  { id: 4, url: 'https://placehold.co/600x400/e2e8f0/64748b?text=Formatura+4' },
  { id: 5, url: 'https://placehold.co/600x400/cbd5e1/475569?text=Formatura+5' },
  { id: 6, url: 'https://placehold.co/600x400/94a3b8/1e293b?text=Formatura+6' },
]);

// Ref para armazenar a URL da foto selecionada para o modal
const selectedPhotoUrl = ref('');
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
                <p class="mb-6 text-lg text-gray-600 dark:text-gray-400">
                    Bem-vindo(a) ao seu álbum! Clique em uma foto para visualizar em tamanho maior.
                </p>

                <Dialog>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <!-- Cada card de foto funciona como um gatilho para o modal -->
                        <DialogTrigger as-child v-for="photo in albumPhotos" :key="photo.id" @click="selectedPhotoUrl = photo.url">
                             <Card class="overflow-hidden cursor-pointer hover:shadow-lg transition-shadow duration-300">
                                <CardContent class="p-0">
                                    <img :src="photo.url" alt="Foto do álbum" class="aspect-[4/3] w-full object-cover" />
                                </CardContent>
                            </Card>
                        </DialogTrigger>
                    </div>

                    <!-- Conteúdo do Modal (Dialog) -->
                    <DialogContent class="max-w-4xl">
                        <DialogHeader>
                            <DialogTitle>Visualizar Foto</DialogTitle>
                             <DialogDescription>
                                Pressione ESC para fechar.
                            </DialogDescription>
                        </DialogHeader>
                        <div class="mt-4">
                            <img :src="selectedPhotoUrl" alt="Foto do álbum em tamanho maior" class="w-full h-auto rounded-md" />
                        </div>
                    </DialogContent>
                </Dialog>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
