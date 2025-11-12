/**
 * Formata um número de telefone brasileiro (11 dígitos)
 * @param telefone - String com números do telefone
 * @returns Telefone formatado como (XX) XXXXX-XXXX
 */
export function formatarTelefone(telefone: string): string {
  const numeros = telefone.replace(/\D/g, '');
  if (numeros.length === 11) {
    return `(${numeros.substring(0, 2)}) ${numeros.substring(2, 7)}-${numeros.substring(7)}`;
  }
  return telefone;
}

/**
 * Formata um CEP brasileiro (8 dígitos)
 * @param cep - String com números do CEP
 * @returns CEP formatado como XXXXX-XXX
 */
export function formatarCep(cep: string): string {
  const numeros = cep.replace(/\D/g, '');
  if (numeros.length === 8) {
    return `${numeros.substring(0, 5)}-${numeros.substring(5)}`;
  }
  return cep;
}

/**
 * Remove formatação de telefone, mantendo apenas números
 * @param telefone - Telefone formatado
 * @returns Apenas números
 */
export function limparTelefone(telefone: string): string {
  return telefone.replace(/\D/g, '');
}

/**
 * Remove formatação de CEP, mantendo apenas números
 * @param cep - CEP formatado
 * @returns Apenas números
 */
export function limparCep(cep: string): string {
  return cep.replace(/\D/g, '');
}

/**
 * Converte vírgula em ponto para preços
 * @param preco - Preço com vírgula ou ponto
 * @returns Preço com ponto decimal
 */
export function normalizarPreco(preco: string | number): number {
  const precoString = String(preco).replace(',', '.');
  return Number(precoString);
}
