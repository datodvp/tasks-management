<script setup>
import { ref, watch } from "vue";
import { router, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    user: String,
    data: Object,
});

let form = useForm({
    firstname: "",
    lastname: "",
});

const date = ref(props.data?.filters?.date);

watch(date, (value) => {
    router.get("/", { date: value });
});

const submit = () => {
    form.post("/employees");
    form.reset();
};
</script>

<template>
    <div>
        <div>
            <Link href="/">
                <h1>Reset {{ user }}</h1>
            </Link>

            <input v-model="date" type="date" />

            <h1 v-if="data">
                Selected week: {{ data.startDate }} - {{ data.endDate }}
            </h1>
        </div>
        <div>
            <form @submit.prevent="submit">
                <h1>დაამატე ახალი თანამშრომელი:</h1>
                <div class="flex flex-col">
                    <input
                        v-model="form.firstname"
                        type="text"
                        placeholder="სახელი"
                        class="p-2 border border-black"
                    />
                    <p class="text-red-500">{{ form.errors.firstname }}</p>
                    <input
                        v-model="form.lastname"
                        type="text"
                        placeholder="გვარი"
                        class="p-2 border border-black"
                    />
                    <p class="text-red-500">{{ form.errors.lastname }}</p>
                </div>

                <button class="p-2 border border-black">დამატება</button>
            </form>
        </div>
    </div>
</template>
