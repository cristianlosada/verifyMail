<script setup>
import { ref } from 'vue'

const email = ref('')
const loading = ref(false)
const result = ref(null)
const errorMsg = ref(null)

async function validateEmail() {
  errorMsg.value = null
  result.value = null
  if (!email.value) {
    errorMsg.value = 'Ingresa un correo'
    return
  }
  loading.value = true
  try {
    const res = await fetch('/api/validate-email', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
      body: JSON.stringify({ email: email.value })
    })
    if (!res.ok) throw new Error('Falló la validación')
    result.value = await res.json()
  } catch (e) {
    errorMsg.value = e.message
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="max-w-lg mx-auto p-6 space-y-4">
    <h1 class="text-2xl font-semibold text-white">Validador de correos</h1>
    <div class="flex gap-2">
      <input v-model="email" type="email" class="border rounded px-3 py-2 flex-1" placeholder="correo@dominio.com" />
      <button @click="validateEmail" :disabled="loading" class="bg-blue-600 text-white px-4 py-2 rounded">
        {{ loading ? 'Validando...' : 'Validar' }}
      </button>
    </div>
    <p v-if="errorMsg" class="text-red-600">{{ errorMsg }}</p>
    <div v-if="result" class="border rounded p-4 text-white bg-gray-800">
      <h2 class="text-lg font-semibold mb-2">Resultado de la validación</h2>
      <p><b>Email:</b> {{ result.email }}</p>
      <p><b>Válido:</b> {{ result.is_valid ? 'Sí' : 'No' }}</p>
      <p v-if="result.reason"><b>Motivo:</b> {{ result.reason }}</p>
      <pre v-if="result.meta" class="text-sm mt-2">{{ result.meta }}</pre>
    </div>
  </div>
</template>

<style>
/* Usa Tailwind ya incluido por Breeze */
</style>
