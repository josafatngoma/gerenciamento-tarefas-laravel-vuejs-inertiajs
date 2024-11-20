<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, Link } from "@inertiajs/vue3";

const props = defineProps({
    task: {
        type: Object,
        default: null,
    },
    statuses: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    title: props.task?.title || "",
    description: props.task?.description || "",
    status_id: props.task.status_id,
    errors: {}
});

// validando os campos
const validateForm = () => {
    const errors = {};

    if (!form.title || form.title.length < 4) {
        errors.title = "O título deve conter pelo menos 4 caracteres.";
    }

    if (!form.description || form.description.length < 12) {
        errors.description = "A descrição deve conter pelo menos 12 caracteres.";
    }

    return errors;
};

// enviando os dados no back
const submit = () => {
    const errors = validateForm();

    if (Object.keys(errors).length > 0) {
        form.errors = errors;
    } else {
        form.errors = {}; //limpando os erros
        form.put(`/tasks/${props.task.id}`);
    }
};
</script>

<template>

    <Head title="Gerenciamento de Tarefas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Tarefa</h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link href="/tasks"><button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Voltar</button>
                        </Link>

                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                                    Título:</label>
                                <input type="text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    placeholder="Enter Title" id="title" v-model="form.title" />
                                <!-- erro -->
                                <p v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                    Descrição:</label>
                                <textarea
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="description" v-model="form.description"
                                    placeholder="Escreva a descrição da tarefa">
                                </textarea>
                                <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">
                                    {{ form.errors.description }}
                                </p>
                            </div>

                            <div class="mb-4">
                                <label for="status_id" class="block text-gray-700 text-sm font-bold mb-2">
                                    Status:
                                </label>
                                <select id="status_id" v-model="form.status_id"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    <option v-for="status in statuses" :key="status.id" :value="status.id">
                                        {{ status.designation }}
                                    </option>
                                </select>
                            </div>

                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
                                Salvar Alterações
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
