<script setup>
import { defineProps, ref, toRef, watch } from "vue";

const props = defineProps({
    showPopUpProp: {
        type: Boolean,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    taskTitle: {
        type: String,
        default: "",
    },
    taskDescription: {
        type: String,
        default: "",
    },
    taskCompleted: {
        type: Boolean,
        default: "",
    },
    onCheckTaskCompleted: {
        type: Function,
        required: true,
    },
    onSubmitTask: {
        type: Function,
        required: true,
    },
    submitAction: {
        type: String,
        required: true,
    },
});

// Create local state copies
const localTaskTitle = ref(props.taskTitle.value);
const localTaskDescription = ref(props.taskDescription.value);
const localTaskCompleted = ref(props.taskCompleted.value);

// Watch for changes and emit updates
const emit = defineEmits([
    "update:taskTitle",
    "update:taskDescription",
    "update:taskCompleted",
]);

watch(localTaskTitle, (newValue) => {
    emit("update:taskTitle", newValue);
});

watch(localTaskDescription, (newValue) => {
    emit("update:taskDescription", newValue);
});

watch(localTaskCompleted, (newValue) => {
    emit("update:taskCompleted", newValue);
});
</script>

<template>
    <v-card :title="title">
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-text-field
                            v-model="localTaskTitle"
                            label="Task Title"
                            required
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row class="v-row">
                    <v-col cols="12">
                        <v-textarea
                            label="Task Description"
                            v-model="localTaskDescription"
                        ></v-textarea>
                    </v-col>
                </v-row>
                <v-row class="v-row">
                    <v-col cols="12">
                        <v-checkbox
                            label="Task Completed"
                            @click="props.onCheckTaskCompleted"
                            v-model="props.taskCompleted"
                        />
                    </v-col>
                </v-row>
                <v-row class="v-row" justify="center">
                    <v-col cols="auto">
                        <v-btn
                            color="buttonSecondary"
                            @click="props.onSubmitTask"
                            >{{ props.submitAction }}</v-btn
                        >
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<style scoped>
.text-field {
    width: 400px;
}
</style>
