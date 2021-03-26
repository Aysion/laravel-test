import { MutationTree } from 'vuex'
import { LocalStorage } from 'quasar'
import { StateInterface } from './state'

const mutation: MutationTree<StateInterface> = {
	setList (state: StateInterface, { key, payload }) {
		LocalStorage.set(key, payload)

		state.list[key] = payload
	}
}

export default mutation
