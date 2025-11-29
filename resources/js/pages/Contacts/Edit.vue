<script setup lang="ts">
import AppSidebarLayout from '@/layouts/app/AppSidebarLayout.vue';
import { Form , Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useI18n } from 'vue-i18n';
import { ChevronLeft } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import  contacts  from '@/routes/contacts';
import { update } from '@/routes/contacts';
import { Card } from '@/components/ui/card';

import { type BreadcrumbItem } from '@/types';

const props = defineProps<{
    contact: {
        id: number;
        name: string;
        email: string;
        phone: string;
        company: string;
    };
}>();

const contact = props.contact;

const { t } = useI18n();

const breadcrumbItems: BreadcrumbItem[] = [
            { 
                title: t('contacts'),
                 href: contacts.index().url 
            },
            { 
                title: t('Edit Contact'),
                href: contacts.edit(contact.id).url 
            },
        ];

// const form = useForm({
//     name: props.contact.name,
//     email: props.contact.email,
//     phone: props.contact.phone,
//     company: props.contact.company,
// });

// const submit = () => {
//     form.put(contacts.update(props.contact.id));
// };
</script>

<template>
    <Head :title="t('Edit Contact')" />

    <AppSidebarLayout :breadcrumbs="breadcrumbItems"
        
    >
            <Card>

        <div class="flex h-full flex-1 flex-col gap-4 p-4 max-w-2xl mx-auto w-full">
            <div class="flex items-center gap-2">
                <Button variant="ghost" size="icon" as-child>
                    <Link :href="contacts.index()">
                        <ChevronLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <h1 class="text-xl font-semibold">{{ t('Edit Contact') }}</h1>
            </div>

            <div class="rounded-md border p-6">
                <Form
            v-bind="update.form(contact.id)"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
                <!-- <form @submit.prevent="submit" class="space-y-4"> -->
                    <div class="space-y-2">
                        <Label for="name">{{ t('Name') }}</Label>
                        <Input id="name" name="name"
                            :default-value="contact.name" required />
                        <InputError :message="errors.name" />
                    </div>

                    <div class="space-y-2">
                        <Label for="email">{{ t('Email') }}</Label>
                        <Input id="email" type="email" name="email"
                            :default-value="contact.email" required />
                        <InputError :message="errors.email" />
                    </div>

                    <div class="space-y-2">
                        <Label for="phone">{{ t('Phone') }}</Label>
                        <Input id="phone" name="phone"
                            :default-value="contact.phone" />
                        <InputError :message="errors.phone" />
                    </div>

                    <div class="space-y-2">
                        <Label for="company">{{ t('Company') }}</Label>
                        <Input id="company" name="company"
                            :default-value="contact.company" />
                        <InputError :message="errors.company" />
                    </div>

                    <div class="flex justify-end pt-4">
                        <Button type="submit" :disabled="processing">
                            {{ t('Update') }}
                        </Button>
                    </div>
                <!-- </form> -->
                 </Form>
            </div>
        </div>
        </Card>
    </AppSidebarLayout>
</template>
