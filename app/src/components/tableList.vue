<template>
	<div class="q-pa-sm q-gutter-sm">
		<q-table
			row-key="id"
			separator="cell"
			:title="title"
			:data="dataList"
			:columns="columns"
		>
			<template v-slot:body="scope" user="">
				<q-tr :props="scope">
					<q-td v-for="(col, key) in scope.colsMap" :key="key" :props="scope">
						<span v-if="col.name !== '_btn_'">{{ scope.row[col.field] }}</span>
						<span v-if="col.name == '_btn_'">
							<q-btn v-if="!scope.row.deleted_at" size="12px" flat dense round icon="delete" class="gt-xs" @click="onDelete(scope)" />
							<q-btn v-else size="12px" flat dense round icon="restore_from_trash" class="gt-xs" @click="dialogForm(scope)" />
							<q-btn v-if="!scope.row.deleted_at" size="12px" flat dense round icon="edit" class="gt-xs" @click="dialogForm(scope)" />
						</span>
					</q-td>
				</q-tr>
			</template>
		</q-table>

		<q-dialog v-model="showDialogForm" transition-show="rotate" transition-hide="rotate" persistent>
			<q-card>
				<q-card-section>
					<div class="text-h6">{{ title }}</div>
				</q-card-section>

				<q-form @submit="onSubmit()" ref="formSlot">
					<q-card-section class="q-pt-none scroll" style="max-height: 50vh">
						<slot name="form" :formData="formData"/>
					</q-card-section>

					<q-card-actions align="right">
						<q-btn flat label="Cancelar" color="primary" v-close-popup />
						<q-btn type="submit" flat label="Salvar" color="primary" v-close-popup />
					</q-card-actions>
				</q-form>
			</q-card>
		</q-dialog>

		<q-dialog v-model="dataDialogConfirm.show" persistent>
			<q-card>
				<q-card-section class="row items-center">
					<q-avatar icon="warning_amber" color="warning" text-color="white" />
					<span class="q-ml-sm" v-html="dataDialogConfirm.body"></span>
				</q-card-section>

				<q-card-actions align="right">
					<q-btn flat label="Confirmar" color="primary" v-close-popup @click="dataDialogConfirm.onConfirm"/>
					<q-btn label="Cancelar" color="negative" v-close-popup />
				</q-card-actions>
			</q-card>
		</q-dialog>
	</div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api"
import { AxiosResponse } from "axios"

export default defineComponent({
	name: 'tableList',
	props: {
		columns: {
			type: Array,
			required: true,
		},
		domain: {
			type: String,
			required: true,
		},
		title: {
			type: String,
			required: true,
		},
	},
	data() {
		return {
			showDialogForm: false,
			dataDialogConfirm: {
				show: false,
				body: '',
			},
			formData: {},
			scopeTable: null,
			dataList: [],
		}
	},
	methods: {
		dialogForm(scopeTable) {
			this.showDialogForm = true
			this.scopeTable = scopeTable
			this.formData = JSON.parse(JSON.stringify(scopeTable.row))
		},
		getDataList() {
			return this.$axios({
				method: 'get',
				url: this.domain,
			}).then((resp: AxiosResponse) => {
				this.dataList = resp.data
			})
		},
		onSubmit() {
			return this.$axios({
				method: this.formData.id ? 'put' : 'post',
				url: `${this.domain}/${(this.formData.id || '')}`,
				data: this.formData,
			}).then((resp: AxiosResponse) => {
				this.$set(this.dataList, this.scopeTable.pageIndex, resp.data)
			})
		},
		onDelete(scopeTable) {
			this.dialogConfirm({
				body: `Deseja deletar esse registro? <br> ID: ${scopeTable.row.id}`,
				onConfirm: () => {
					this.processDelete(scopeTable.row.id)
				}
			})
		},
		processDelete(id) {
			return this.$axios({
				method: 'delete',
				url: `${this.domain}/${id}`,
			}).then((resp: AxiosResponse) => {
				console.log(resp.data)
			})
		},
		dialogConfirm(dataDialogConfirm) {
			Object.assign(this.dataDialogConfirm, dataDialogConfirm, { show: true })
		}
	},
	mounted() {
		this.getDataList()
	}
})
</script>

<style>

</style>
