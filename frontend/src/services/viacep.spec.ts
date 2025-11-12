import { describe, it, expect, vi, beforeEach } from 'vitest';

describe('ViaCEP Integration', () => {
  beforeEach(() => {
    vi.restoreAllMocks();
  });

  it('busca endereço por CEP com sucesso', async () => {
    const mockResponse = {
      ok: true,
      json: async () => ({
        cep: '01310-100',
        logradouro: 'Avenida Paulista',
        bairro: 'Bela Vista',
        localidade: 'São Paulo',
        uf: 'SP'
      })
    };

    globalThis.fetch = vi.fn().mockResolvedValue(mockResponse) as any;

    const response = await fetch('https://viacep.com.br/ws/01310100/json/');
    const data = await response.json();

    expect(data.logradouro).toBe('Avenida Paulista');
    expect(data.bairro).toBe('Bela Vista');
  });

  it('trata erro quando CEP é inválido', async () => {
    const mockResponse = {
      ok: true,
      json: async () => ({ erro: true })
    };

    globalThis.fetch = vi.fn().mockResolvedValue(mockResponse) as any;

    const response = await fetch('https://viacep.com.br/ws/00000000/json/');
    const data = await response.json();

    expect(data.erro).toBe(true);
  });

  it('trata erro de rede', async () => {
    globalThis.fetch = vi.fn().mockRejectedValue(new Error('Network error')) as any;

    await expect(fetch('https://viacep.com.br/ws/01310100/json/'))
      .rejects.toThrow('Network error');
  });
});
