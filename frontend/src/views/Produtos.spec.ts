/**@vitest-environment happy-dom */
import { describe, it, expect, beforeEach } from 'vitest'
import { mount } from '@vue/test-utils'
import Produtos from './Produtos.vue'
import api from '../services/api'
import MockAdapter from 'axios-mock-adapter'

const mockApi = new MockAdapter(api)

describe('Produtos.vue', () => {
  beforeEach(() => {
    mockApi.reset()
  })

  it('renderiza título e formulário', () => {
    mockApi.onGet('/api/produtos').reply(200, { data: [] })
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    const wrapper = mount(Produtos)
    expect(wrapper.find('h2').text()).toBe('Produtos')
    expect(wrapper.find('select').exists()).toBe(true)
  })

  it('carrega lista de produtos', async () => {
    const produtos = [
      { id: 1, nome: 'Pastel Carne', preco: 5.5, tipo_produto: { nome: 'Pastel Salgado' } },
      { id: 2, nome: 'Pastel Queijo', preco: 6.0, tipo_produto: { nome: 'Pastel Salgado' } }
    ]
    mockApi.onGet('/api/produtos').reply(200, { data: produtos })
    mockApi.onGet('/api/clientes').reply(200, { data: [] })

    const wrapper = mount(Produtos)
    await wrapper.vm.$nextTick()
    await new Promise(resolve => setTimeout(resolve, 50))

    const rows = wrapper.findAll('tbody tr')
    expect(rows.length).toBe(2)
  })

  it('valida campos obrigatórios', async () => {
    mockApi.onGet('/api/produtos').reply(200, { data: [] })
    mockApi.onGet('/api/clientes').reply(200, { data: [] })

    const wrapper = mount(Produtos)
    await wrapper.vm.$nextTick()

    const form = wrapper.find('form')
    await form.trigger('submit.prevent')
    await wrapper.vm.$nextTick()

    const alert = wrapper.find('.alert')
    expect(alert.exists()).toBe(true)
  })

  it('envia dados para API ao salvar', async () => {
    mockApi.onGet('/api/produtos').reply(200, { data: [] })
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    mockApi.onPost('/api/produtos').reply(201, { id: 1 })

    const wrapper = mount(Produtos)
    await wrapper.vm.$nextTick()

    const inputs = wrapper.findAll('input')
    await inputs[0].setValue('Pastel de Carne')
    await inputs[1].setValue('5.50')
    await inputs[2].setValue('http://example.com/foto.jpg')

    const form = wrapper.find('form')
    await form.trigger('submit.prevent')
    await new Promise(resolve => setTimeout(resolve, 50))

    expect(mockApi.history.post.length).toBe(1)
  })

  it('exibe tipos de produto no select', async () => {
    mockApi.onGet('/api/produtos').reply(200, { data: [] })
    mockApi.onGet('/api/clientes').reply(200, { data: [] })

    const wrapper = mount(Produtos)
    await wrapper.vm.$nextTick()
    await new Promise(resolve => setTimeout(resolve, 50))

    const options = wrapper.find('select').findAll('option')
    expect(options.length).toBeGreaterThan(0)
    expect(options[0].text()).toContain('Pastel')
  })

  it('chama API delete ao remover produto', async () => {
    const produtos = [{ id: 1, nome: 'Pastel', preco: 5.5, tipo_produto: { nome: 'Salgado' } }]
    mockApi.onGet('/api/produtos').reply(200, { data: produtos })
    mockApi.onGet('/api/clientes').reply(200, { data: [] })
    mockApi.onDelete('/api/produtos/1').reply(204)

    const wrapper = mount(Produtos)
    await wrapper.vm.$nextTick()
    await new Promise(resolve => setTimeout(resolve, 50))

    const removeBtn = wrapper.find('tbody button')
    await removeBtn.trigger('click')
    await new Promise(resolve => setTimeout(resolve, 50))

    expect(mockApi.history.delete.length).toBe(1)
  })
})
