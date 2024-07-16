<script setup>
import {computed, ref, inject, defineAsyncComponent} from "vue";
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from '@/Components/Pagination.vue'
import Breadcrumb from '@/Components/Breadcrumb.vue';
const FiltersModal = defineAsyncComponent(() => import("@/Components/Tickets/FiltersModal.vue"));

const props = defineProps({
    tickets: Array,
})

const Datetime = inject('Datetime');
const currentPage = ref(1);
const perPage = ref(10);
const filters = ref({
    show: false,
    title: '',
    description: '',
    userName: '',
    userEmail: null,
    date: [null, null],
    priority: null,
    status: null,
})

const paginatedTickets = computed(() => {
    let start = (currentPage.value - 1) * perPage.value;
    let end = start + perPage.value;
    return props.tickets.slice(start, end);
})
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex justify-between items-center py-6">
                <Breadcrumb
                    :items="[
                        // Dashboard link is always shown by default
                        {text: 'Tickets'}, // You can add a link property
                    ]"
                />
                <div class="space-x-2">
                    <button
                        type="button"
                        class="min-w-[120px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        @click="filters.show = true"
                    >
                        Filters
                    </button>
                    <Link
                        :href="route('tickets.create')"
                        class="min-w-[120px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Create Ticket
                    </Link>
                </div>
            </div>
            <div class="overflow-x-auto shadow  sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Submitted
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            User
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Priority
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                    <tr v-for="ticket in paginatedTickets" :key="ticket.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ Datetime && new Datetime(ticket.created_at) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">{{ ticket.title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.user.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.priority }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            <Link :href="route('tickets.show', [ticket.id])">
                                View
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <Pagination
                    v-model:current-page="currentPage"
                    :total-items="tickets.length"
                    :per-page="perPage"
                />
            </div>
        </div>
        <FiltersModal :filters="filters" />
    </AuthenticatedLayout>

</template>

