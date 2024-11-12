<script setup>
import Layout from '@/Layout/Layout.vue';
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  ChevronLeft,
} from 'lucide-vue-next'
import { Link, useForm, router } from '@inertiajs/vue3';
import {  ref  } from "vue";

const props = defineProps({
  brand: Object,
  errors: Object,
});


const form = useForm({
  name: null,
  logo: null,
});
const imagePreview = ref(props.brand ? props.brand.logo : null);
const handleFileChange = (event) => {
  const file = event.target.files[0];
  form.logo = file;

  // Create a preview for the selected image
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result; // Set the preview URL
    };
    reader.readAsDataURL(file); // Read the file to create a base64 preview
  } else {
    imagePreview.value = null; // Clear the preview if no file is selected
  }
}
// create and edit logic
if (props.brand) {
  form.name = props.brand.name;
}

const submit = () => {
  if (props.brand)
      form._method = 'put',
      router.post(route("brand.update", props.brand.id), form,{
                onError: (error) => {
                    form.errors = error;
                },
            });
  else
    form.post(route("brand.store"), form,{
                onError: (error) => {
                    form.errors = error;
                },
            });
};

</script>

<template>
  <Layout>
    <div class=" grid  flex-1 auto-rows-max gap-4">
      <div class="flex items-center gap-4">
        <Link :href="route('brand.index')">
        <Button variant="outline" size="icon" class="h-7 w-7">
          <ChevronLeft class="h-4 w-4" />
          <span class="sr-only">Back</span>
        </Button>
        </Link>
        <h1 class="flex-1 shrink-0 whitespace-nowrap text-xl font-semibold tracking-tight sm:grow-0">
          Brands
        </h1>
      </div>
      <div class="grid gap-4 md:grid-cols-[1fr_250px] lg:grid-cols-3 lg:gap-8">
        <div class="grid auto-rows-max items-start gap-4 lg:col-span-2 lg:gap-8">
          <Card>
            <CardHeader>
              <CardTitle>New Brand</CardTitle>
            </CardHeader>
            <CardContent>
              <form @submit.prevent="submit" class="grid gap-6">

                <div class="grid gap-3">
                  <Label for="name">Name</Label>
                  <Input v-model="form.name" id="name" type="text" class="w-full" placeholder="Enter Brand name" />
                  <span v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</span>
                </div>
                <div class="grid gap-3">
                  <Label for="logo">Logo</Label>
                  <Input id="logo" type="file" @input="handleFileChange($event)" />
                  <span v-if="form.errors.logo" class="text-red-500 text-sm">{{ form.errors.logo }}</span>
                  <img :src="imagePreview" v-if="imagePreview"
                    class="h-2/3 w-1/3 object-cover transition-all hover:scale-105" />
                </div>
                <div class=" items-center gap-2 ml-auto flex">
                  <Link :href="route('brand.index')">
                  <Button variant="outline" size="sm" type="button">
                    Discard
                  </Button>
                  </Link>
                  <Button size="sm" type="submit">
                    Save Brand
                  </Button>
                </div>
              </form>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  </Layout>
</template>