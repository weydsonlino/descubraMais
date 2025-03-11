<script setup lang="ts">

const props = defineProps<{
  modelValue?: string
  name?: string
  placeholder?: string
  type?: string
}>()

const emit = defineEmits(['update:modelValue'])

const updateValue = (event: Event) => {
  emit('update:modelValue', (event.target as HTMLInputElement).value)
}

</script>

<template>
  <input
    :type="props.type"
    :placeholder="props.placeholder"
    :value="props.modelValue"
    @input="updateValue"
  />
</template>

<style scoped>
input{
  display: flex;
  width: 456px;
  height: 40.53px;
  padding: 0px 7.606px;
  margin-bottom: 20px;
  align-items: center;
  gap: -48px;
  border-radius: 14.262px;
  border: 0.951px solid #FFF;
  background: #FFF;
  box-shadow: 0px 0px 4px 0px rgba(0, 0, 0, 0.25);
}
</style>
