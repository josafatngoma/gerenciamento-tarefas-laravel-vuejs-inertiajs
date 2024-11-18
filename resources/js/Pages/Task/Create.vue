<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link } from "@inertiajs/vue3";

const form = useForm({
  title: "",
  description: "",
});

const submit = () => {
  form.post("/tasks");
};
</script>

<template>
    <Head title="Gerenciamento de Tarefas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Criar Tarefa</h2>
        </template>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link href="/tasks"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Voltar</button></Link>
                        
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label 
                                    for="title" 
                                    class="block text-gray-700 text-sm font-bold mb-2">
                                    Título:</label>
                                <input 
                                    type="text" 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                    placeholder="Enter Title" 
                                    id="title"
                                    v-model="form.title" />

                            </div>

                            <div class="mb-4">
                                <label 
                                    for="description" 
                                    class="block text-gray-700 text-sm font-bold mb-2">
                                    Descrição:</label>
                                <textarea 
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" 
                                    v-model="form.description" 
                                    placeholder="Escreva a descrição da tarefa"></textarea>
                            </div>

                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
                                Criar
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
