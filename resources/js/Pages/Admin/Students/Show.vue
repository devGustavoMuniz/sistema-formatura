<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Upload, Trash2, ArrowLeft, X } from 'lucide-vue-next';
import { AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog';

const props = defineProps({
    student: {
        type: Object,
        required: true
    }
});

// --- Lógica de Upload ---
const form = useForm({
    photos: [],
});
const fileInput = ref(null);
const imagePreviews = ref([]);

const openFileDialog = () => fileInput.value.click();

const onFileChange = (event) => {
    const files = event.target.files;
    if (!files) return;
    const newFiles = Array.from(files);
    form.photos.push(...newFiles);
    const newPreviews = newFiles.map(file => ({ url: URL.createObjectURL(file), name: file.name }));
    imagePreviews.value.push(...newPreviews);
    if (fileInput.value) fileInput.value.value = '';
};

const removePreview = (index) => {
    imagePreviews.value.splice(index, 1);
    form.photos.splice(index, 1);
};

const submitPhotos = () => {
    form.post(route('admin.students.photos.store', props.student.id), {
        onSuccess: () => {
            imagePreviews.value = [];
            form.reset('photos');
            router.reload({ only: ['student'] });
        }
    });
};

// --- INÍCIO DA LÓGICA DE EXCLUSÃO ---
// 1. Refs para controlar o estado do modal
const confirmingDelete = ref(false);
const photoToDelete = ref(null);

// 2. Função para abrir o modal e definir qual foto será excluída
const confirmPhotoDelete = (photo) => {
    photoToDelete.value = photo;
    confirmingDelete.value = true;
};

// 3. Função que lida com a confirmação de exclusão
const deletePhoto = () => {
    if (!photoToDelete.value) return;

    router.delete(route('admin.photos.destroy', photoToDelete.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            confirmingDelete.value = false;
            photoToDelete.value = null;
            router.reload({ only: ['student'] });
        },
    });
    
};
// --- FIM DA LÓGICA DE EXCLUSÃO ---
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
                                    <span class="text-lg">{{ student.institute?.name }}</span>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>
                    
                    <TabsContent value="photos">
                        <Card>
                            <CardHeader>
                                <CardTitle>Gerenciar Fotos</CardTitle>
                                <CardDescription>Faça o upload ou remova as fotos do álbum deste aluno.</CardDescription>
                            </CardHeader>
                            <CardContent>
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
                                <hr class="my-8" v-if="student.photos.length > 0 && imagePreviews.length > 0" />
                                <h3 class="text-lg font-medium mb-4 mt-8" v-if="student.photos.length > 0">Fotos Existentes</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <Card v-for="photo in student.photos" :key="photo.id" class="group relative">
                                        <img :src="photo.url" alt="Foto do álbum" class="rounded-t-lg aspect-video object-cover">
                                        <CardFooter class="p-2">
                                            <Button @click="confirmPhotoDelete(photo)" variant="destructive" size="sm" class="w-full opacity-0 group-hover:opacity-100 transition-opacity">
                                                <Trash2 class="h-4 w-4 mr-2" />
                                                Excluir
                                            </Button>
                                        </CardFooter>
                                    </Card>
                                </div>
                            </CardContent>
                        </Card>
                    </TabsContent>
                </Tabs>
            </div>
        </div>

        <AlertDialog :open="confirmingDelete" @update:open="confirmingDelete = false">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Você tem certeza?</AlertDialogTitle>
                    <AlertDialogDescription>
                        Essa ação não pode ser desfeita e irá deletar permanentemente esta foto.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="confirmingDelete = false">Cancelar</AlertDialogCancel>
                    <AlertDialogAction @click="deletePhoto">Confirmar Exclusão</AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AuthenticatedLayout>
</template>
