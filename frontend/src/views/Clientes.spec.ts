/**@vitest-environment happy-dom */
import { describe, it, expect, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import Clientes from './Clientes.vue'
import api from '../services/api'
import MockAdapter from 'axios-mock-adapter'

const mockApi = new MockAdapter(api)

describe('Clientes.vue', () => {
  beforeEach(() => {
    mockApi.reset()
  })

  it('renderiza título e formulário', () => {
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    const wrapper = mount(Clientes)
    expect(wrapper.find('h2').text()).toBe('Clientes')
    expect(wrapper.findAll('input').length).toBeGreaterThan(0)
  })

  it('carrega lista de clientes na montagem', async () => {
    const clientes = [
      { id: 1, nome: 'João', email: 'joao@test.com' },
      { id: 2, nome: 'Maria', email: 'maria@test.com' }
    ]
    mockApi.onGet('/api/clientes').reply(200, { data: clientes })

    const wrapper = mount(Clientes)
    await wrapper.vm.$nextTick()
    await new Promise(resolve => setTimeout(resolve, 50))

    const rows = wrapper.findAll('tbody tr')
    expect(rows.length).toBe(2)
  })

  it('valida campos obrigatórios ao salvar', async () => {
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    mockApi.onPost('/api/clientes').reply(201, {})

    const wrapper = mount(Clientes)
    await wrapper.vm.$nextTick()

    const form = wrapper.find('form')
    await form.trigger('submit.prevent')
    await wrapper.vm.$nextTick()

    const alert = wrapper.find('.alert')
    expect(alert.exists()).toBe(true)
  })

  it('envia dados válidos para API ao salvar', async () => {
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    mockApi.onPost('/api/clientes').reply(201, { id: 1 })

    const wrapper = mount(Clientes)
    await wrapper.vm.$nextTick()

    const inputs = wrapper.findAll('input')
    await inputs[0].setValue('João Silva')
    await inputs[1].setValue('joao@test.com')
    await inputs[2].setValue('11999999999')
    await inputs[3].setValue('01234-567')

    const form = wrapper.find('form')
    await form.trigger('submit.prevent')
    await new Promise(resolve => setTimeout(resolve, 50))

    expect(mockApi.history.post.length).toBe(1)
    const postData = JSON.parse(mockApi.history.post[0].data)
    expect(postData.nome).toBe('João Silva')
    expect(postData.email).toBe('joao@test.com')
  })

  it('limpa formulário ao clicar em Limpar', async () => {
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    const wrapper = mount(Clientes)
    await wrapper.vm.$nextTick()

    const inputs = wrapper.findAll('input')
    await inputs[0].setValue('João')
    expect((inputs[0].element as HTMLInputElement).value).toBe('João')

    const clearBtn = wrapper.findAll('button').find(btn => btn.text().includes('Limpar'))
    await clearBtn?.trigger('click')
    await wrapper.vm.$nextTick()

    expect((inputs[0].element as HTMLInputElement).value).toBe('')
  })

  it('chama API delete ao remover cliente', async () => {
    const clientes = [{ id: 1, nome: 'João', email: 'joao@test.com' }]
    mockApi.onGet('/api/clientes').reply(200, { data: clientes })
    mockApi.onDelete('/api/clientes/1').reply(204)

    const wrapper = mount(Clientes)
    await wrapper.vm.$nextTick()
    await new Promise(resolve => setTimeout(resolve, 50))

    const removeBtn = wrapper.find('tbody button')
    await removeBtn.trigger('click')
    await new Promise(resolve => setTimeout(resolve, 50))

    expect(mockApi.history.delete.length).toBe(1)
    expect(mockApi.history.delete[0].url).toBe('/api/clientes/1')
  })

  it('exibe erros de validação do backend', async () => {
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    mockApi.onPost('/api/clientes').reply(422, {
      errors: { email: ['O email já existe'] }
    })

    const wrapper = mount(Clientes)
    await wrapper.vm.$nextTick()

    const inputs = wrapper.findAll('input')
    await inputs[0].setValue('João')
    await inputs[1].setValue('joao@test.com')

    const form = wrapper.find('form')
    await form.trigger('submit.prevent')
    await new Promise(resolve => setTimeout(resolve, 50))

    const alert = wrapper.find('.alert')
    expect(alert.exists()).toBe(true)
  })
})
