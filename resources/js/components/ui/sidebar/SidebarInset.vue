<script setup lang="ts">
import type { HTMLAttributes } from 'vue'
import { cn } from '@/lib/utils'

const props = defineProps<{
  class?: HTMLAttributes['class']
}>()
</script>

<template>
  <main
    data-slot="sidebar-inset"
    :class="cn(
      'bg-background relative flex w-full flex-1 flex-col',
      'md:peer-data-[variant=inset]:m-2 md:peer-data-[variant=inset]:ml-0 md:peer-data-[variant=inset]:rounded-xl md:peer-data-[variant=inset]:shadow-sm md:peer-data-[variant=inset]:peer-data-[state=collapsed]:ml-0 z-10',
      props.class,
    )"
  >


      <div
  class="w-full h-full absolute top-0 left-0 bg-[url('/assets/img/noise.jpg')] bg-contain bg-center opacity-[.1]  dark:opacity-[.1]  -z-20 rounded-xl"
/>
<div
  class="w-full h-full absolute top-0 left-0 bg-[url('/assets/img/grid.svg')] bg-contain bg-center opacity-[.1] invert blur-[0.5px]  dark:blur-[0px] dark:invert-0  dark:opacity-[.1]  -z-20  rounded-xl"
/>


    <slot />
  </main>
</template>
