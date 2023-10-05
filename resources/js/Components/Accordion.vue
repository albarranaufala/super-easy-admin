<script setup lang="ts">
import { ref } from "vue";

const props = defineProps({
    open: {
        type: Boolean,
        default: () => false,
    },
});

const open = ref(props.open);

const enter = (element: Element) => {
    const width = getComputedStyle(element).width;

    if (element instanceof HTMLElement) {
        element.style.width = width;
        element.style.position = "absolute";
        element.style.visibility = "hidden";
        element.style.height = "auto";

        const height = getComputedStyle(element).height;

        element.style.width = "";
        element.style.position = "";
        element.style.visibility = "";
        element.style.height = "0";

        // Force repaint to make sure the
        // animation is triggered correctly.
        getComputedStyle(element).height;

        // Trigger the animation.
        // We use `requestAnimationFrame` because we need
        // to make sure the browser has finished
        // painting after setting the `height`
        // to `0` in the line above.
        requestAnimationFrame(() => {
            element.style.height = height;
        });
    }
};

const afterEnter = (element: Element) => {
    if (element instanceof HTMLElement) {
        element.style.height = "auto";
    }
};

const leave = (element: Element) => {
    const height = getComputedStyle(element).height;

    if (element instanceof HTMLElement) {
        element.style.height = height;

        // Force repaint to make sure the
        // animation is triggered correctly.
        getComputedStyle(element).height;

        requestAnimationFrame(() => {
            element.style.height = "0";
        });
    }
};
</script>
<template>
    <div>
        <div @click="open = !open">
            <slot name="trigger" :open="open" />
        </div>
        <div class="overflow-hidden">
            <Transition
                name="expand"
                @enter="enter"
                @after-enter="afterEnter"
                @leave="leave"
            >
                <div v-show="open">
                    <slot name="content" />
                </div>
            </Transition>
        </div>
    </div>
</template>

<style scoped>
.expand-enter-active,
.expand-leave-active {
    transition: height 250ms ease-in-out;
    overflow: hidden;
}

.expand-enter,
.expand-leave-to {
    height: 0;
}
</style>
