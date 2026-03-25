<script setup lang="ts">
/* Importa o layout padrão do sistema para envolver a página */
import AppLayout from '@/layouts/AppLayout.vue';

/* Importa o componente Link do Inertia para navegação sem reload */
import { Link, router } from '@inertiajs/vue3';

/* Importa o tipo BreadcrumbItem para tipar corretamente os breadcrumbs */
import { type BreadcrumbItem } from '@/types';
import { CirclePlus, Eye, Pencil, Search, Trash } from 'lucide-vue-next';

/* Importar o componente de paginação */
import Pagination from '@/components/Pagination.vue';

/* Importar o componente para apresentar a mensagem de sucesso e erro */
import FlashMessage from '@/components/FlashMessage.vue';

/* Importar o componente para excluir o registro */
import DeleteButton from '@/components/DeleteButton.vue';
import { reactive } from 'vue';

/* Define a interface do veículo, útil para tipagem TypeScript */
export interface Vehicle {
    id: number;
    name: string;
    started_at: string;
    finished_at: string;
}

/* Recebe os dados da controller via props usando Inertia */
const props = defineProps<{
    tasks: {
        data: Vehicle[]; // Lista de Tarefas
        links: { url: string | null; label: string; active: boolean }[]; // Links da paginação
    };
    name?: string;
    started_at?: string;
    finished_at?: string;
}>();

const filters = reactive({
    name: props.name || '',
    started_at: props.started_at || '',
    finished_at: props.finished_at || '',
});

const search = () => {
    router.get('/tasks', filters, {
        preserveState: true,
        preserveScroll: true,
    });
};
const clearFilters = () => {
    filters.name = '';
    filters.started_at = '';
    filters.finished_at = '';
    search();
};

/* Define os breadcrumbs que serão exibidos no layout */
const breadcrumbItems: BreadcrumbItem[] = [{ title: 'Tarefas', href: '' }];
</script>

<template>
    <!-- Usa o layout padrão e passa os breadcrumbs para exibição -->
    <AppLayout :breadcrumbs="breadcrumbItems">
        <!-- Define o título da página para o <head> -->

        <Head title="Tarefas" />

        <!-- Container principal da página -->
        <div class="content-box">
            <!-- Título da seção -->
            <div class="content-box-header">
                <h3 class="content-box-title">Tarefas</h3>
                <div class="content-box-btn">
                    <Link
                        href="/tasks/create"
                        class="flex cursor-pointer items-center space-x-1 rounded bg-green-500 px-2 py-1 text-sm text-white transition-colors hover:bg-green-600"
                    >
                        <CirclePlus class="h-4 w-4" />
                        <span>Cadastrar</span>
                    </Link>
                </div>
            </div>

            <!-- Apresentar a mensagem de sucesso ou erro -->
            <FlashMessage />

            <form @submit.prevent="search" class="form-search">
                <input type="text" v-model="filters.name" class="form-input" placeholder="Digite o nome da tarefa" />
                <input type="datetime-local" v-model="filters.started_at" class="form-input" />
                <input type="datetime-local" v-model="filters.finished_at" class="form-input" />

                <div class="mb-2 flex gap-1">
                    <button type="submit" class="btn-primary align-icon-btn">
                        <Search class="h-4 w-4" />
                        <span> Pesquisar </span>
                    </button>
                    <button type="button" @click="clearFilters" class="btn-warning align-icon-btn">
                        <Trash class="h-4 w-4" />
                        <span> Limpar </span>
                    </button>
                </div>
            </form>

            <!-- Container da tabela com bordas e sombra -->
            <div class="table-container">
                <!-- Tabela de Tarefas -->
                <table class="table">
                    <thead>
                        <tr class="table-header">
                            <!-- Cabeçalhos da tabela -->
                            <th class="table-row-header">ID</th>
                            <th class="table-row-header">Nome</th>
                            <th class="table-row-header">Início</th>
                            <th class="table-row-header">Fim</th>
                            <th class="table-row-header">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Itera sobre os Tarefas recebidos das props -->
                        <tr v-for="task in props.tasks.data" :key="task.id" class="table-body">
                            <!-- Colunas da tabela -->
                            <td class="table-row-body">
                                {{ task.id }}
                            </td>
                            <td class="table-row-body">
                                {{ task.name }}
                            </td>
                            <td class="table-row-body">
                                {{ task.started_at ? new Date(task.started_at).toLocaleString() : '' }}
                            </td>
                            <td class="table-row-body">
                                {{ task.finished_at ? new Date(task.finished_at).toLocaleString() : '' }}
                            </td>
                            <td class="table-actions">
                                <div class="table-actions-align">
                                    <Link :href="`/tasks/${task.id}`" class="btn-primary align-icon-btn">
                                        <Eye class="h-4 w-4" />
                                        <span>Visualizar</span>
                                    </Link>

                                    <Link :href="`/tasks/${task.id}/edit`" class="btn-warning align-icon-btn">
                                        <Pencil class="h-4 w-4" />
                                        <span>Editar</span>
                                    </Link>

                                    <!-- Botão de apagar -->
                                    <!-- Usa o componente genérico -->
                                    <DeleteButton :url="`/tasks/${task.id}`" title="Deseja realmente apagar esta tarefa?" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <Pagination :links="props.tasks.links" />
            </div>
        </div>
    </AppLayout>
</template>
