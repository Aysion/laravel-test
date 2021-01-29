<template>
	<q-page>
		<tableList title="Tipo de Usuário" :columns="columns" :dataList="dataList">
			<template v-slot:form>
				<p v-for="n in 15" :key="n">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
			</template>
		</tableList>
	</q-page>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'
import { AxiosResponse } from 'axios'
import tableList from '../../components/tableList.vue'

export default defineComponent({
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
		getDataList() {
			return this.$axios({
				method: 'get',
				url: 'userType',
			}).then((resp: AxiosResponse) => {
				this.dataList = resp.data
			})
		}
	},
	mounted() {
		this.getDataList()
	}
})
</script>

<style>

</style>
