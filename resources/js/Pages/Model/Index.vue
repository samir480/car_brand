<script setup>
import Button from '@/components/ui/button/Button.vue';
import Layout from '@/Layout/Layout.vue';
import DataTable from '@/components/ui/table/DataTable.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  models: Object,
  search: String,
})

const search = computed(() => props.search || '');

const Columns = [
  { key: 'id', label: 'ID' },
  { key: 'brand', label: 'Brand' },
  { key: 'name', label: 'Name' },
  { key: 'year', label: 'Year' },
  {
    key: 'image', label: 'Image',
    render: (row) => `<img src="${row.image}" alt="Logo" style="width: 50px; height: auto;" />` // Custom render logic for image
  },
  { key: 'actions' },
]
const Actions = [
  { route: 'model.edit', label: 'Edit', method: 'get' },
  { route: 'model.destroy', label: 'Delete', method: 'delete' }
]
</script>

<template>
  <Layout>

    <div class="space-y-4 p-8 pt-6">
      <div class="flex items-center justify-between space-y-2">
        <h2 class="text-3xl font-bold tracking-tight">
          Brand Models
        </h2>
        <div class="flex items-center space-x-2">
          <Link :href="route('model.create')"><Button>Add Brand Model</Button></Link>
        </div>
      </div>
    </div>

      <div class="flex flex-1 items-center justify-center rounded-lg border border-dashed shadow-sm"
        v-if="!models.data.length && search == ''">
        <div class="flex flex-col items-center gap-1 text-center">
          <h3 class="text-2xl font-bold tracking-tight">
            You have no models
          </h3>
          <Link :href="route('model.create')">
          <Button class="mt-4">
            Add Brand Model
          </Button>
          </Link>
        </div>
      </div>

      <DataTable :columns="Columns" :data="models" :actions="Actions" :search="search" :only="['models','search']" v-else />
  </Layout>
</template>