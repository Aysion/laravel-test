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
							<q-btn v-if="!scope.row.deleted_at" size="12px" flat dense round icon="delete" class="gt-xs" />
							<q-btn v-else size="12px" flat dense round icon="restore_from_trash" class="gt-xs" @click="dialogForm(scope)" />
							<q-btn v-if="!scope.row.deleted_at" size="12px" flat dense round icon="edit" class="gt-xs" @click="dialogForm(scope)" />
						</span>
					</q-td>
				</q-tr>
			</template>
		</q-table>

		<q-dialog v-model="showDialogForm" transition-show="rotate" transition-hide="rotate">
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
	</div>
</template>

<script lang="ts">
import { defineComponent } from "@vue/composition-api"

export default defineComponent({
	name: 'tableList',
	props: {
		dataList: {
			type: Array,
			required: true,
		},
		columns: {
			type: Array,
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
			formData: {},
			scopeTable: null,
		}
	},
	methods: {
		dialogForm(scopeTable) {
			this.showDialogForm = true

			this.scopeTable = scopeTable
			this.formData = JSON.parse(JSON.stringify(scopeTable.row))
		},
		onSubmit() {
			this.$emit('onSubmit', { scopeTable: this.scopeTable, formData: this.formData })
		},
	},
})
</script>

<style>

</style>
