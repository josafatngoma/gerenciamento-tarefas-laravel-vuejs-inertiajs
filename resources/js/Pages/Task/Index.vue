<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

/** props */
const props = defineProps({
    tasks: {
        type: Array,
        default: () => [],
    },
    statuses: {
        type: Array,
        default: () => [],
    },
});
const { tasks, statuses } = props;

const form = useForm({});

//eliminar uma tarefa
const deleteTask = (id) => {
    form.delete(`tasks/${id}`);
};

// Retornar a classe CSS com base no status
const getStatusColor = (status) => {
    switch (status.designation) {
        case 'Pendente':
            return 'text-yellow-500 font-bold';
        case 'Concluída':
            return 'text-green-500 font-bold';
        case 'Em Curso':
            return 'text-blue-500 font-bold';
        default:
            return 'text-gray-500 font-bold';
    }
};

// fitrando tarefas por status ou datas
let currentStatus = ref(null);
let currentDateFilter = ref(null);

const filterTasks = computed(() => {
    let filtered = tasks;

    // por status
    if (currentStatus.value !== null) {
        filtered = filtered.filter(task => task.status_id === currentStatus.value);
    }

    // por data de criação ou atualização
    if (currentDateFilter.value === 'created') {
        filtered = filtered.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
    } else if (currentDateFilter.value === 'updated') {
        filtered = filtered.sort((a, b) => new Date(a.updated_at) - new Date(b.updated_at));
    }

    return filtered;
});

</script>

<template>
    <Head title="Gerenciamento de Tarefas" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Gerenciar Tarefas
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <Link href="tasks/create"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Criar Nova Tarefa</button></Link>
                        
                        <div class="flex flex-col items-end space-y-4 mb-4 float-right">

                            <!-- filtrar por status -->
                            <div >
                                <h3>Filtrar:</h3>
                                <button
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded"
                                    :class="{ 'bg-gray-500 text-white': currentStatus === null }"
                                    @click="currentStatus = null"
                                >
                                    Todos
                                </button>
                                <button
                                    v-for="status in statuses"
                                    :key="status.id"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded"
                                    :class="{ 'bg-gray-500 text-white': currentStatus === status.id }"
                                    @click="currentStatus = status.id"
                                >
                                    {{ status.designation }}
                                </button>

                            </div>

                            <!-- filtrar por datas -->
                            <div class="flex items-center space-x-4 mb-4 float-right">
                                <button
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded"
                                    :class="{ 'bg-gray-500 text-white': currentDateFilter === 'created' }"
                                    @click="currentDateFilter = 'created'"
                                >
                                    Data da criação
                                </button>
                                <button
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded"
                                    :class="{ 'bg-gray-500 text-white': currentDateFilter === 'updated' }"
                                    @click="currentDateFilter = 'updated'"
                                >
                                    Data da atualização
                                </button>
                            </div>

                        </div>

                        <table class="table-auto w-full">
                            <thead>
                              <tr>
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Título</th>
                                <th class="border px-4 py-2">Descrição</th>
                                <th class="border px-4 py-2">Criação</th>
                                <th class="border px-4 py-2">Última atualização</th>
                                <th class="border px-4 py-2">Estado</th>
                                <th class="border px-4 py-2" width="250px">Opções</th>
                              </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(task, index) in filterTasks" :key="task.id">
                                  <td class="border px-4 py-2">{{ index + 1 }}</td>
                                  <td class="border px-4 py-2">{{ task.title }}</td>
                                  <td class="border px-4 py-2">{{ task.description }}</td>
                                  <td class="border px-4 py-2">{{ new Date(task.created_at).toLocaleDateString() }}</td>
                                  <td class="border px-4 py-2">{{ new Date(task.updated_at).toLocaleString() }}</td>


                                  <td class="border px-4 py-2 text-center">
                                    <span :class="getStatusColor(statuses?.find(s => s.id === task.status_id))">
                                        {{ statuses?.find(s => s.id === task.status_id)?.designation || '...' }}
                                    </span>
                                  </td>


                                  <td class="border px-4 py-2 text-center">

                                    <template v-if="task.status_id !== 3"> <!-- exibe apenas que a tarefa não estiver como concluída -->
                                        <Link :href="`tasks/${task.id}/edit`">
                                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Editar
                                            </button>
                                        </Link>
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2"
                                            @click="deleteTask(task.id)"
                                        >
                                            Remover
                                        </button>
                                    </template>
                                    
                                    <template v-else>
                                        <!-- Opcional: Mostrar algo para indicar que a tarefa foi concluída -->
                                        <span class="text-green-500 font-bold">Tarefa Concluída</span>
                                    </template>

                                  </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
