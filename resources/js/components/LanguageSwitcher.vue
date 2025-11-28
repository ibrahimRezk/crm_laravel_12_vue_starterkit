<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { router } from '@inertiajs/vue3';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Button } from '@/components/ui/button';
import { Globe } from 'lucide-vue-next';

const { locale, t } = useI18n();

const switchLanguage = (lang: string) => {
    router.post('/language', { locale: lang }, {
        onSuccess: () => {
            // Force a reload to ensure all components re-render with new locale and dir
             window.location.reload();
        }
    });
};
</script>

<template>
    <DropdownMenu>
        <DropdownMenuTrigger as-child>
            <Button variant="ghost" size="icon" class="h-8 w-8 rounded-full">
                <Globe class="h-4 w-4" />
                <span class="sr-only">{{ t('language') }}</span>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
            <DropdownMenuItem @click="switchLanguage('en')">
                {{ t('english') }}
            </DropdownMenuItem>
            <DropdownMenuItem @click="switchLanguage('ar')">
                {{ t('arabic') }}
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
