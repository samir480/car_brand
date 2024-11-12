<script setup>
import Layout from '@/Layout/Layout.vue';
import { defineProps } from 'vue';

import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { Package } from 'lucide-vue-next'

defineProps({
  brands_count: Number,
  models_count: Number,
})

</script>

<template>
  <Layout>
    <div class="flex items-center">
      <h1 class="text-lg font-semibold md:text-2xl">
        Dashboard
      </h1>
    </div>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
      <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle class="text-sm font-medium">
            Total Brands
          </CardTitle>
          <Package class="h-4 w-4" />
        </CardHeader>
        <CardContent>
          <div class="text-2xl font-bold">
            {{ brands_count }}
          </div>
        </CardContent>
      </Card>
      <Card>
        <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
          <CardTitle class="text-sm font-medium">
            Total Brand Models
          </CardTitle>
          <Package class="h-4 w-4" />
        </CardHeader>
        <CardContent>
          <div class="text-2xl font-bold">
            {{ models_count }}
          </div>
        </CardContent>
      </Card>
    </div>
  </Layout>
</template>