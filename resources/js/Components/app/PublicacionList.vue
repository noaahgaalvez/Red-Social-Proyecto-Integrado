<script setup>
import PublicacionItem from '@/Components/app/PublicacionItem.vue';

const publicacion1 = {
	usuario: {
		id: 1,
		avatar: 'https://randomuser.me/api/portraits/men/1.jpg',
		nombre: 'Jose Luis',
	},
	attachments: [
		{
			id: 1,
			name: 'test.png',
			path: 'https://picsum.photos/500',
			type: 'image/png',
		},
		{
			id: 2,
			name: 'test.png',
			path: 'https://picsum.photos/750',
			type: 'image/png',
		},
		{
			id: 3,
			name: 'MyDocument.docx',
			path: '#',
			type: 'application/msword',
		},
	],
	body: `
		<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit
			Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
			Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
		</p>
	`,
	created_at: '2024-05-10 10:00:00',
}

const publicacion2 = {
	usuario: {
		id: 2,
		avatar: 'https://randomuser.me/api/portraits/men/10.jpg',
		nombre: 'Antonio Jose',
	},
	body: `
		<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit
			Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.
			Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
		</p>
	`,
	created_at: '2024-05-10 12:00:00',
}

</script>

<template>
	<div class="overflow-auto">
		<PublicacionItem :publicacion="publicacion1" />
		<PublicacionItem :publicacion="publicacion2" />
	</div>
</template>