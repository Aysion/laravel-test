<template>
	<q-page>
		<tableList title="Usuário" domain="user" :columns="columns">
			<template #form="slotProps">
				<q-input filled v-model="slotProps.formData.name" label="Nome" />

				<label>Nivel: {{slotProps.formData.level}}</label>
				<q-slider
					v-model="slotProps.formData.level"
					:min="0"
					:max="100"
					label
					color="light-blue"
				/>
			</template>
		</tableList>
	</q-page>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'
import tableList from '../components/tableList.vue'

export default defineComponent({
	name: 'user.page',
	components: {
		tableList,
	},
	data() {
		return {
			dataList: [],
			columns: [
				{
					name: 'id',
					label: "ID",
					field: "id",
					headerStyle: 'width: 100px',
					sortable: true,
				},
				{
					name: 'email',
					label: "E-mail",
					field: "email",
					align: "left",
					sortable: true,
				},
				{
					name: 'name',
					label: "Tipo",
					field: "name",
					align: 'left',
					sortable: true,
				},
				{
					name: 'userType',
					label: "Tipo de Usuário",
					field: "userType.name",
					align: 'left',
					sortable: true,
				},
				{
					name: '_btn_',
					align: 'left',
					headerStyle: 'width: 100px',
				},
			],
		}
	},
	methods: {

	},
})
</script>

<style>

</style>
