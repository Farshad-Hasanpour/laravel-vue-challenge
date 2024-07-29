<script setup>
import {computed, ref, inject, defineAsyncComponent} from "vue";
import { Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from '@/Components/Pagination.vue'
import Breadcrumb from '@/Components/Breadcrumb.vue';
const FiltersModal = defineAsyncComponent(() => import("@/Components/Tickets/FiltersModal.vue"));

const props = defineProps({
    tickets: Object,
    totalWithoutFilter: Number,
})

const priorities = inject('ticketPriorities');
// contains null for filters
const allPriorities = [
    {value: null, title: 'Not Selected'},
    {value: 'low', title: 'Low'},
    {value: 'medium', title: 'Medium'},
    {value: 'high', title: 'High'},
]

const statuses = inject('ticketStatuses');
// contains null for filters
const allStatus = [
    {value: null, title: 'Not Selected'},
    {value: 'open', title: 'Open'},
    {value: 'in_progress', title: 'In Progress'},
    {value: 'closed', title: 'Closed'},
]

const Datetime = inject('Datetime');
const currentPage = ref(1);
const perPage = ref(10);
const showFilters = ref(false);

const params = Object.fromEntries(new URLSearchParams(window.location.search));

const filters = ref({
    title: params.title || '',
    description: params.description || '',
    userName: params.userName || '',
    userEmail: params.userEmail || '',
    priority: params.priority || null,
    status: params.status || null,
    dateStart: params.dateStart || null,
    dateEnd: params.dateEnd || null,
})

const filtersCount = computed(() => {
    return Object.values(filters.value).filter(item => !!item)?.length || 0;
})

/* const filteredTickets = computed(() => {
    if(!filtersCount.value) return props.tickets.data;
    return props.tickets.data.filter(item => {
        if(
            item.priority === filters.value.priority ||
            item.status === filters.value.status ||
            (filters.value.title && item.title.includes(filters.value.title)) ||
            (filters.value.description && item.description.includes(filters.value.description)) ||
            (filters.value.userName && item.user.name.includes(filters.value.userName)) ||
            (filters.value.userEmail && item.user.email.includes(filters.value.userEmail))
        ) return true

        // Date range search
        let start = null;
        let end = null;
        const updated = new Date(item.updated_at);
        updated.setHours(0, 0, 0, 0);

        if(filters.value.dateStart){
            start = new Date(filters.value.dateStart);
            start.setHours(0, 0, 0, 0);
        }
        if(filters.value.dateEnd){
            end = new Date(filters.value.dateEnd);
            end.setHours(24, 0, 0, 0);
        }

        return Boolean(
            (start && !end && start.getTime() <= updated.getTime()) ||
            (end && !start && end.getTime() > updated.getTime()) ||
            (start && end && start.getTime() <= updated.getTime() && end.getTime() > updated.getTime())
        );
    });
})

const paginatedTickets = computed(() => {
    let start = (currentPage.value - 1) * perPage.value;
    let end = start + perPage.value;
    return filteredTickets.value.slice(start, end);
})*/
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between items-center py-6">
                <Breadcrumb
                    :items="[
                        // Dashboard link is always shown by default
                        {text: `Tickets ${filtersCount ? `(${tickets.total} of ${totalWithoutFilter})` : ''}`}, // You can add a link property
                    ]"
                    class="w-full sm:w-auto my-2"
                />
                <div class="space-x-2">
                    <button
                        type="button"
                        class="min-w-[120px] inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        @click="showFilters = true"
                    >
                        Filters {{filtersCount ? `(${filtersCount})` : null}}
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
                    <tr v-if="!tickets.data.length" class="text-gray-400">
                        <td colspan="7" class="text-lg text-center p-2">No Records Found</td>
                    </tr>
                    <tr v-for="ticket in tickets.data" :key="ticket.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ Datetime && new Datetime(ticket.created_at) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-100">{{ ticket.title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ ticket.user.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ priorities[ticket.priority] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ statuses[ticket.status] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            <Link :href="route('tickets.show', [ticket.id])">
                                View
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <Pagination :items="tickets" :filters="filters" />
            </div>
        </div>
        <FiltersModal
            v-model="showFilters"
            :filters="filters"
            :all-priorities="allPriorities"
            :all-status="allStatus"
            :current-page="tickets.current_page"
        />
    </AuthenticatedLayout>

</template>

