<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <component
                v-for="(link, key) in links"
                :key="key"
                :is="link.url ? Link : 'span'"
                :href="link.url"
                v-html="link.label"
                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded"
                :class="{
                    'bg-gray-700 text-white': link.active,
                    'text-gray-400 cursor-default': !link.url,
                    'hover:bg-gray-100': link.url
                }"
            />
        </div>
    </div>
</template>