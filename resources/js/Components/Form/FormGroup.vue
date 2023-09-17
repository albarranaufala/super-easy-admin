<template>
    <div class="flex flex-wrap">
        <div class="w-full sm:flex-[3_3_0%] py-3 pr-4">
            <slot name="label" />
        </div>
        <div class="w-full sm:flex-[9_9_0%] min-w-">
            <slot name="input" />
        </div>
    </div>
</template>
