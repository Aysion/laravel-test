<template>
	<q-page>
		<tableList title="Tipo de Usuário" domain="userType" :columns="columns">
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
	name: 'userType.page',
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
					name: 'level',
					label: "Nivel",
					field: "level",
					headerStyle: 'width: 100px',
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
