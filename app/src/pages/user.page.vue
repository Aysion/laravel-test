<template>
	<q-page>
		<tableList title="Usuário" domain="user" :columns="columns">
			<template #form="slotProps">
				<q-input v-model="slotProps.formData.name" label="Nome" filled />

				<q-input
					type="email"
					filled
					v-model="slotProps.formData.email"
					label="E-mail"
				/>

				<q-select
					label="Tipo de Usuário"
					option-value="id"
					option-label="name"
					v-model="slotProps.formData.user_type_id"
					:options="options.userType.length ? options.userType : [ slotProps.formData.userType ]"
					emit-value
					map-options
					filled
				/>

				<q-separator class="q-my-md" />

				<q-input
					type="password"
					v-model="slotProps.formData.password"
					label="Nova Senha"
					filled
				/>
			</template>
		</tableList>
	</q-page>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api";
import tableList from "../components/tableList.vue";

export default defineComponent({
	name: "user.page",
	components: {
		tableList,
	},
	data() {
		return {
			dataPayload: null,
			dataList: [],
			columns: [
				{
					name: "id",
					label: "ID",
					field: "id",
					headerStyle: "width: 100px",
					sortable: true,
				},
				{
					name: "email",
					label: "E-mail",
					field: "email",
					align: "left",
					sortable: true,
				},
				{
					name: "name",
					label: "Nome",
					field: "name",
					align: "left",
					sortable: true,
				},
				{
					name: "userType",
					label: "Tipo de Usuário",
					field: "userType.name",
					align: "left",
					sortable: true,
				},
				{
					name: "_btn_",
					align: "left",
					headerStyle: "width: 100px",
				},
			],
			options: {
				userType: [],
			},
		};
	},
	methods: {
		getListUserType() {
			this.$axios({
				method: "get",
				url: "userType",
			}).then(({ data }) => {
				this.options.userType = data;
			});
		},
	},
	mounted() {
		this.dataPayload = this.$q.localStorage.getItem('dataPayload')

		this.getListUserType();
	},
});
</script>

<style>
</style>
