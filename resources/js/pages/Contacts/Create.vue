<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import contacts from '@/routes/contacts';
import { type BreadcrumbItem } from '@/types';
import { Form, Head, Link } from '@inertiajs/vue3';
import { ChevronLeft } from 'lucide-vue-next';
import { store } from '@/routes/contacts';


import { useI18n } from 'vue-i18n';

const { t } = useI18n();

// const form = useForm({
//     name: '',
//     email: '',
//     phone: '',
//     company: '',
// });

// const submit = () => {
//     form.post(contacts.store);
// };

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: t('contacts'),
        href: contacts.index().url,
    },
    {
        title: t('Create Contact'),
        href: contacts.create().url,
    },
];
</script>

<template>
    <Head :title="t('Create Contact')" />

    <AppSidebarLayout :breadcrumbs="breadcrumbItems">
        <Card>
            <div
                class="mx-auto flex h-full w-full max-w-2xl flex-1 flex-col gap-4 p-4"
            >
                <div class="flex items-center gap-2">
                    <Button variant="ghost" size="icon" as-child>
                        <Link :href="contacts.index()">
                            <ChevronLeft class="h-4 w-4" />
                        </Link>
                    </Button>
                    <h1 class="text-xl font-semibold">
                        {{ t('Create Contact') }}
                    </h1>
                </div>

                <div class="rounded-md border p-6">
                    <Form
                        v-bind="store.form()"
                        :reset-on-success="[
                            'password',
                            'password_confirmation',
                        ]"
                        v-slot="{ errors, processing }"
                        class="flex flex-col gap-6"
                    >
                        <!-- <form @submit.prevent="submit" class="space-y-4"> -->

                        <div class="space-y-2">
                            <Label for="name">{{ t('Name') }}</Label>
                            <Input id="name" name="name" required />
                            <InputError :message="errors.name" />
                        </div>

                        <div class="space-y-2">
                            <Label for="email">{{ t('Email') }}</Label>
                            <Input
                                id="email"
                                type="email"
                                name="email"
                                required
                            />
                            <InputError :message="errors.email" />
                        </div>

                        <div class="space-y-2">
                            <Label for="phone">{{ t('Phone') }}</Label>
                            <Input id="phone" name="phone" />
                            <InputError :message="errors.phone" />
                        </div>

                        <div class="space-y-2">
                            <Label for="company">{{ t('Company') }}</Label>
                            <Input id="company" name="company" />
                            <InputError :message="errors.company" />
                        </div>

                        <div class="flex justify-end pt-4">
                            <Button type="submit" :disabled="processing">
                                {{ t('Save') }}
                            </Button>
                        </div>
                        <!-- </form> -->
                    </Form>
                </div>
            </div>
        </Card>
    </AppSidebarLayout>
</template>
