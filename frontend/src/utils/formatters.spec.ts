import { describe, it, expect } from 'vitest';
import {
  formatarTelefone,
  formatarCep,
  limparTelefone,
  limparCep,
  normalizarPreco
} from './formatters';

describe('formatters.ts', () => {
  describe('formatarTelefone', () => {
    it('formata telefone de 11 dígitos corretamente', () => {
      expect(formatarTelefone('11987654321')).toBe('(11) 98765-4321');
    });

    it('retorna input original se não tiver 11 dígitos', () => {
      expect(formatarTelefone('1234')).toBe('1234');
    });

    it('remove caracteres não numéricos antes de formatar', () => {
      expect(formatarTelefone('(11) 98765-4321')).toBe('(11) 98765-4321');
    });
  });

  describe('formatarCep', () => {
    it('formata CEP de 8 dígitos corretamente', () => {
      expect(formatarCep('01310100')).toBe('01310-100');
    });

    it('retorna input original se não tiver 8 dígitos', () => {
      expect(formatarCep('123')).toBe('123');
    });

    it('remove caracteres não numéricos antes de formatar', () => {
      expect(formatarCep('01310-100')).toBe('01310-100');
    });
  });

  describe('limparTelefone', () => {
    it('remove formatação mantendo apenas números', () => {
      expect(limparTelefone('(11) 98765-4321')).toBe('11987654321');
    });

    it('funciona com string já limpa', () => {
      expect(limparTelefone('11987654321')).toBe('11987654321');
    });
  });

  describe('limparCep', () => {
    it('remove formatação mantendo apenas números', () => {
      expect(limparCep('01310-100')).toBe('01310100');
    });

    it('funciona com string já limpa', () => {
      expect(limparCep('01310100')).toBe('01310100');
    });
  });

  describe('normalizarPreco', () => {
    it('converte vírgula em ponto', () => {
      expect(normalizarPreco('10,50')).toBe(10.50);
    });

    it('funciona com ponto decimal', () => {
      expect(normalizarPreco('10.50')).toBe(10.50);
    });

    it('funciona com número', () => {
      expect(normalizarPreco(10.50)).toBe(10.50);
    });

    it('funciona com string de número inteiro', () => {
      expect(normalizarPreco('10')).toBe(10);
    });
  });
});
