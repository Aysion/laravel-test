<template>
	<div class="q-pa-sm q-gutter-sm">
		<q-table
			row-key="id"
			separator="cell"
			:title="title"
			:data="dataList"
			:columns="columns"
		>
			<template v-slot:body="scope">
				<q-tr :props="scope">
					<q-td v-for="(col, key) in scope.colsMap" :key="key" :props="scope">
						<span v-if="col.name !== '_btn_'">{{ scope.row[col.field] }}</span>
						<span v-if="col.name == '_btn_'">
							<q-btn v-if="!scope.row.deleted_at" size="12px" flat dense round icon="delete" class="gt-xs" />
							<q-btn v-else size="12px" flat dense round icon="restore_from_trash" class="gt-xs" @click="dialogForm()" />
							<q-btn v-if="!scope.row.deleted_at" size="12px" flat dense round icon="edit" class="gt-xs" @click="dialogForm()" />
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

				<q-card-section class="q-pt-none scroll" style="max-height: 50vh">
					<slot name="form"/>
				</q-card-section>

				<q-card-actions align="right">
					<q-btn flat label="Cancelar" color="primary" v-close-popup />
					<q-btn flat label="Salvar" color="primary" v-close-popup />
				</q-card-actions>
			</q-card>
		</q-dialog>
	</div>
</template>

<script lang="ts">
export default {
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
		}
	},
	methods: {
		dialogForm() {
			this.showDialogForm = true
		}
	}
}
</script>

<style>

</style>