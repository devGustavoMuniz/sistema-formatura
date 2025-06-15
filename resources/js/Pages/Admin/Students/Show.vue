<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Upload, Trash2, ArrowLeft, X } from 'lucide-vue-next';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle, AlertDialogTrigger } from '@/components/ui/alert-dialog';

// Dados mocados para visualização
const props = defineProps({
    student: {
        type: Object,
        default: () => ({
            id: 1, name: 'Gustavo Muniz', ra: '202010140', email: 'gustavo@exemplo.com', institution: 'Universidade Federal de Lavras',
            photos: [
                { id: 1, url: 'https://placehold.co/600x400/e2e8f0/64748b?text=Foto+1' },
                { id: 2, url: 'https://placehold.co/600x400/e2e8f0/64748b?text=Foto+2' },
                { id: 3, url: 'https://placehold.co/600x400/e2e8f0/64748b?text=Foto+3' },
                { id: 4, url: 'https://placehold.co/600x400/e2e8f0/64748b?text=Foto+4' },
            ]
        })
    }
});

// useForm para o upload de fotos
const form = useForm({
    photos: [],
});

// Ref para o input de arquivo
const fileInput = ref(null);
// Ref para a prévia das imagens
const imagePreviews = ref([]);

// Função para abrir a janela de seleção de arquivo
const openFileDialog = () => {
    fileInput.value.click();
};

// Função para lidar com os arquivos selecionados
const onFileChange = (event) => {
    const files = event.target.files;
    if (!files) return;

    const newFiles = Array.from(files);

    // Adiciona os NOVOS arquivos ao formulário, mantendo os existentes
    form.photos.push(...newFiles);

    // Cria as URLs para a prévia e adiciona ao array existente
    const newPreviews = newFiles.map(file => ({
        url: URL.createObjectURL(file),
        name: file.name
    }));
    imagePreviews.value.push(...newPreviews);

    // Limpa o valor do input para permitir selecionar o mesmo arquivo novamente
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

// Função para submeter o formulário de upload
const submitPhotos = () => {
    // A lógica real de upload seria aqui
    // form.post(route('admin.students.photos.store', props.student.id), {
    //     onSuccess: () => {
    //         // Limpar prévias após o sucesso
    //         imagePreviews.value = [];
    //         form.reset('photos');
    //     }
    // });
    console.log('Enviando fotos:', form.photos);
    alert('Simulação: Fotos enviadas! Verifique o console.');
    imagePreviews.value = []; // Limpa a prévia após o "envio"
    form.reset('photos');
};

// Função para remover uma imagem da lista de prévia
const removePreview = (index) => {
    imagePreviews.value.splice(index, 1);
    form.photos.splice(index, 1);
};
</script>

<template>
    <Head :title="`Detalhes de ${student.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('admin.students.index')">
                    <Button variant="outline" size="icon">
                        <ArrowLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Detalhes do Aluno: {{ student.name }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Tabs default-value="photos" class="w-full">
                    <TabsList class="grid w-full grid-cols-2">
                        <TabsTrigger value="details">Dados do Aluno</TabsTrigger>
                        <TabsTrigger value="photos">Fotos do Álbum</TabsTrigger>
                    </TabsList>

                    <!-- Aba de Detalhes -->
                    <TabsContent value="details">
                        <Card>
                            <CardHeader>
                                <CardTitle>Informações de Cadastro</CardTitle>
                            </CardHeader>
                            <CardContent class="space-y-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-muted-foreground">Nome</span>
                                    <span class="text-lg">{{ student.name }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-muted-foreground">Email</span>
                                    <span class="text-lg">{{ student.email }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-muted-foreground">RA</span>
                                    <span class="text-lg">{{ student.ra }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-muted-foreground">Instituição</span>
                                    <span class="text-lg">{{ student.institution }}</span>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>

                    <!-- Aba de Fotos -->
                    <TabsContent value="photos">
                        <Card>
                            <CardHeader>
                                <CardTitle>Gerenciar Fotos</CardTitle>
                                <CardDescription>Faça o upload ou remova as fotos do álbum deste aluno.</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <!-- Dropzone Funcional -->
                                <div @click="openFileDialog" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-primary transition-colors">
                                    <input
                                        ref="fileInput"
                                        type="file"
                                        class="hidden"
                                        multiple
                                        accept="image/*"
                                        @change="onFileChange"
                                    />
                                    <Upload class="mx-auto h-12 w-12 text-gray-400" />
                                    <p class="mt-4 text-sm text-muted-foreground">Arraste e solte os arquivos aqui, ou</p>
                                    <Button variant="outline" class="mt-2" @click.stop="openFileDialog">Selecione os Arquivos</Button>
                                </div>

                                <!-- Área de Prévia do Upload -->
                                <div v-if="imagePreviews.length > 0" class="mt-8">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium">Prévia do Upload</h3>
                                        <Button @click="submitPhotos" :disabled="form.processing">
                                            <Upload class="h-4 w-4 mr-2" />
                                            Enviar {{ imagePreviews.length }} Foto(s)
                                        </Button>
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        <div v-for="(preview, index) in imagePreviews" :key="index" class="relative group">
                                            <img :src="preview.url" :alt="preview.name" class="rounded-lg aspect-video object-cover">
                                            <Button @click="removePreview(index)" variant="destructive" size="icon" class="absolute top-2 right-2 h-7 w-7 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <X class="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-8" v-if="imagePreviews.length > 0" />

                                <!-- Galeria de Fotos Existentes -->
                                <h3 class="text-lg font-medium mb-4" v-if="student.photos.length > 0">Fotos Existentes</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <Card v-for="photo in student.photos" :key="photo.id" class="group relative">
                                        <img :src="photo.url" alt="Foto do álbum" class="rounded-t-lg aspect-video object-cover">
                                        <CardFooter class="p-2">
                                            <AlertDialog>
                                                <AlertDialogTrigger as-child>
                                                    <Button variant="destructive" size="sm" class="w-full opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <Trash2 class="h-4 w-4 mr-2" />
                                                        Excluir
                                                    </Button>
                                                </AlertDialogTrigger>
                                                <AlertDialogContent>
                                                    <AlertDialogHeader>
                                                        <AlertDialogTitle>Você tem certeza?</AlertDialogTitle>
                                                        <AlertDialogDescription>
                                                            Essa ação não pode ser desfeita. Isso irá deletar permanentemente esta foto do álbum do aluno.
                                                        </AlertDialogDescription>
                                                    </AlertDialogHeader>
                                                    <AlertDialogFooter>
                                                        <AlertDialogCancel>Cancelar</AlertDialogCancel>
                                                        <AlertDialogAction>Confirmar Exclusão</AlertDialogAction>
                                                    </AlertDialogFooter>
                                                </AlertDialogContent>
                                            </AlertDialog>
                                        </CardFooter>
                                    </Card>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
