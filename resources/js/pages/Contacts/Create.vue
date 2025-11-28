<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useI18n } from 'vue-i18n';
import { ChevronLeft } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import   contacts   from '@/routes/contacts'; 

const { t } = useI18n();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    company: '',
});

const submit = () => {
    form.post(contacts.store);
};
</script>

<template>
    <Head :title="t('Create Contact')" />

    <AppSidebarLayout
        :breadcrumbs="[
            { title: t('contacts'), href: contacts.index() },
            { title: t('Create Contact'), href: contacts.create() },
        ]"
    >
        <div class="flex h-full flex-1 flex-col gap-4 p-4 max-w-2xl mx-auto w-full">
            <div class="flex items-center gap-2">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="contacts.index()">
                        <ChevronLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <h1 class="text-xl font-semibold">{{ t('Create Contact') }}</h1>
            </div>

            <div class="rounded-md border p-6">
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="space-y-2">
                        <Label for="name">{{ t('Name') }}</Label>
                        <Input id="name" v-model="form.name" required />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div class="space-y-2">
                        <Label for="email">{{ t('Email') }}</Label>
                        <Input id="email" type="email" v-model="form.email" required />
                        <InputError :message="form.errors.email" />
                    </div>

                    <div class="space-y-2">
                        <Label for="phone">{{ t('Phone') }}</Label>
                        <Input id="phone" v-model="form.phone" />
                        <InputError :message="form.errors.phone" />
                    </div>

                    <div class="space-y-2">
                        <Label for="company">{{ t('Company') }}</Label>
                        <Input id="company" v-model="form.company" />
                        <InputError :message="form.errors.company" />
                    </div>

                    <div class="flex justify-end pt-4">
                        <Button type="submit" :disabled="form.processing">
                            {{ t('Save') }}
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AppSidebarLayout>
</template>
