<script setup>
defineProps({
	selected: Boolean,
	text: String,
})
</script>

<template>
  <button
	:class="[
	  'w-full rounded-lg py-2.5 text-sm font-medium leading-5',
	  'ring-white/60 ring-offset-2 ring-offset-blue-400 focus:outline-none focus:ring-2',
	  selected
		? 'font-bold bg-white text-blue-700 shadow'
		: 'text-blue-100 hover:bg-white/[0.12] hover:text-white',
	]"
  >
	{{ text }}
  </button>
</template>