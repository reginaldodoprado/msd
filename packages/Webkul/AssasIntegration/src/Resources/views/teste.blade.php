<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste AssasIntegration - Bagisto</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 15px;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
        }
        
        .btn-success {
            background: linear-gradient(45deg, #28a745, #1e7e34);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .result-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .status-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        
        .status-success { background-color: #28a745; }
        .status-error { background-color: #dc3545; }
        .status-warning { background-color: #ffc107; }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 text-primary">
                <i class="fas fa-credit-card"></i> AssasIntegration
            </h1>
            <p class="lead text-muted">Teste do Pacote de Integração com Asaas no Bagisto</p>
        </div>

        <div class="row">
            <!-- Formulário de Teste -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-play-circle"></i> Testar Criação de Pagamento
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="testePagamentoForm">
                            <div class="mb-3">
                                <label for="customer" class="form-label">Customer ID *</label>
                                <input type="text" class="form-control" id="customer" name="customer" 
                                       value="cus_000005219613" required>
                                <div class="form-text">ID do cliente no Asaas</div>
                            </div>

                            <div class="mb-3">
                                <label for="value" class="form-label">Valor *</label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" class="form-control" id="value" name="value" 
                                           value="100.00" step="0.01" min="0.01" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="billingType" class="form-label">Tipo de Pagamento *</label>
                                <select class="form-select" id="billingType" name="billingType" required>
                                    <option value="PIX">PIX</option>
                                    <option value="BOLETO">Boleto</option>
                                    <option value="CREDIT_CARD">Cartão de Crédito</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="dueDate" class="form-label">Data de Vencimento *</label>
                                <input type="date" class="form-control" id="dueDate" name="dueDate" 
                                       value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>

                            <!-- Campos específicos para cartão de crédito -->
                            <div id="cartaoCampos" style="display: none;">
                                <hr class="my-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-credit-card"></i> Dados do Cartão
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="holderName" class="form-label">Nome no Cartão *</label>
                                            <input type="text" class="form-control" id="holderName" name="holderName" 
                                                   value="marcelo h almeida" placeholder="Como está impresso no cartão">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cardNumber" class="form-label">Número do Cartão *</label>
                                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" 
                                                   value="5162 3062 1937 8829" placeholder="1234 5678 9012 3456" maxlength="19">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="expiryMonth" class="form-label">Mês *</label>
                                            <select class="form-select" id="expiryMonth" name="expiryMonth">
                                                <option value="">Mês</option>
                                                @for($i = 1; $i <= 12; $i++)
                                                    <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" 
                                                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) == '05' ? 'selected' : '' }}>
                                                        {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="expiryYear" class="form-label">Ano *</label>
                                            <select class="form-select" id="expiryYear" name="expiryYear">
                                                <option value="">Ano</option>
                                                @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                                    <option value="{{ $i }}" {{ $i == '2024' ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="ccv" class="form-label">CVV *</label>
                                            <input type="text" class="form-control" id="ccv" name="ccv" 
                                                   value="318" placeholder="123" maxlength="4">
                                        </div>
                                    </div>
                                </div>
                                
                                <hr class="my-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user"></i> Dados do Titular
                                </h6>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customerName" class="form-label">Nome Completo *</label>
                                            <input type="text" class="form-control" id="customerName" name="customerName" 
                                                   value="Marcelo Henrique Almeida" placeholder="Nome completo do titular">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customerEmail" class="form-label">E-mail *</label>
                                            <input type="email" class="form-control" id="customerEmail" name="customerEmail" 
                                                   value="marcelo.almeida@gmail.com" placeholder="email@exemplo.com">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customerCpf" class="form-label">CPF/CNPJ *</label>
                                            <input type="text" class="form-control" id="customerCpf" name="customerCpf" 
                                                   value="249.715.637-92" placeholder="123.456.789-00">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customerPhone" class="form-label">Telefone *</label>
                                            <input type="text" class="form-control" id="customerPhone" name="customerPhone" 
                                                   value="(47) 3801-0919" placeholder="(11) 99999-9999">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customerMobile" class="form-label">Celular *</label>
                                            <input type="text" class="form-control" id="customerMobile" name="customerMobile" 
                                                   value="(47) 99878-1877" placeholder="(11) 99999-9999">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customerPostalCode" class="form-label">CEP *</label>
                                            <input type="text" class="form-control" id="customerPostalCode" name="customerPostalCode" 
                                                   value="89223-005" placeholder="12345-678">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customerAddressNumber" class="form-label">Número *</label>
                                            <input type="text" class="form-control" id="customerAddressNumber" name="customerAddressNumber" 
                                                   value="277" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="customerAddressComplement" class="form-label">Complemento</label>
                                            <input type="text" class="form-control" id="customerAddressComplement" name="customerAddressComplement" 
                                                   placeholder="Apto, casa, etc.">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-rocket"></i> Testar Pagamento
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Teste de Conexão -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-wifi"></i> Testar Conexão com API
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Teste se a conexão com a API do Asaas está funcionando corretamente.
                        </p>
                        
                        <button type="button" class="btn btn-success w-100" onclick="testarConexao()">
                            <i class="fas fa-plug"></i> Testar Conexão
                        </button>
                        
                        <div id="conexaoResult" class="result-box" style="display: none;">
                            <h6>Resultado do Teste:</h6>
                            <div id="conexaoContent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gerenciamento de Customers -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="fas fa-users"></i> Gerenciar Customers
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Listar Customers Existentes:</h6>
                                <button type="button" class="btn btn-info w-100" onclick="listarCustomers()">
                                    <i class="fas fa-list"></i> Listar Customers
                                </button>
                                <div id="customersList" class="mt-3" style="display: none;"></div>
                            </div>
                            <div class="col-md-6">
                                <h6>Criar Customer de Teste:</h6>
                                <button type="button" class="btn btn-warning w-100" onclick="criarCustomerTeste()">
                                    <i class="fas fa-user-plus"></i> Criar Customer Teste
                                </button>
                                <div id="customerCriado" class="mt-3" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Resultados -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list"></i> Resultados dos Testes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="resultados"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status do Sistema -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle"></i> Status do Sistema
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <span class="status-indicator status-success"></span>
                                    <span>Pacote Carregado</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <span class="status-indicator status-success"></span>
                                    <span>Service Provider</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <span class="status-indicator status-success"></span>
                                    <span>Classes Disponíveis</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <span class="status-indicator status-warning"></span>
                                    <span>Configuração .env</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // CSRF Token para requisições AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Testar criação de pagamento
        $('#testePagamentoForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // Mostrar loading
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Testando...');
            btn.prop('disabled', true);
            
            $.ajax({
                url: '{{ route("assas.testar-pagamento") }}',
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        mostrarResultado('✅ Pagamento criado com sucesso!', response.data, 'success');
                    } else {
                        mostrarResultado('❌ Erro ao criar pagamento', response.message, 'danger');
                    }
                },
                error: function(xhr) {
                    let message = 'Erro desconhecido';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    mostrarResultado('❌ Erro na requisição', message, 'danger');
                },
                complete: function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }
            });
        });

        // Testar conexão com API
        function testarConexao() {
            const btn = $('.btn-success');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Testando...');
            btn.prop('disabled', true);
            
            $.ajax({
                url: '{{ route("assas.testar-conexao") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        $('#conexaoContent').html(`
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> ${response.message}
                            </div>
                            <pre class="bg-light p-3 rounded">${JSON.stringify(response.data, null, 2)}</pre>
                        `);
                    } else {
                        $('#conexaoContent').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> ${response.message}
                            </div>
                        `);
                    }
                    $('#conexaoResult').show();
                },
                error: function(xhr) {
                    let message = 'Erro desconhecido';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    $('#conexaoContent').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> ${message}
                        </div>
                    `);
                    $('#conexaoResult').show();
                },
                complete: function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }
            });
        }

        // Mostrar resultados
        function mostrarResultado(titulo, conteudo, tipo) {
            const timestamp = new Date().toLocaleTimeString();
            const html = `
                <div class="alert alert-${tipo} alert-dismissible fade show">
                    <h6 class="alert-heading">${titulo}</h6>
                    <small class="text-muted">${timestamp}</small>
                    <hr>
                    <pre class="mb-0">${JSON.stringify(conteudo, null, 2)}</pre>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            $('#resultados').prepend(html);
        }

        // Auto-fill da data de vencimento
        document.getElementById('dueDate').value = new Date(Date.now() + 24*60*60*1000).toISOString().split('T')[0];
        
        // Mostrar campos de cartão automaticamente se for cartão de crédito
        document.addEventListener('DOMContentLoaded', function() {
            const billingType = document.getElementById('billingType');
            const cartaoCampos = document.getElementById('cartaoCampos');
            
            if (billingType.value === 'CREDIT_CARD') {
                cartaoCampos.style.display = 'block';
            }
        });
        
        // Mostrar/ocultar campos de cartão baseado no tipo de pagamento
        document.getElementById('billingType').addEventListener('change', function() {
            const cartaoCampos = document.getElementById('cartaoCampos');
            if (this.value === 'CREDIT_CARD') {
                cartaoCampos.style.display = 'block';
            } else {
                cartaoCampos.style.display = 'none';
            }
        });
        
        // Máscara para número do cartão
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = value;
        });
        
        // Máscara para CPF
        document.getElementById('customerCpf').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            e.target.value = value;
        });
        
        // Máscara para telefone
        document.getElementById('customerPhone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            e.target.value = value;
        });
        
        document.getElementById('customerMobile').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            e.target.value = value;
        });
        
        // Máscara para CEP
        document.getElementById('customerPostalCode').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{5})(\d{3})/, '$1-$2');
            e.target.value = value;
        });
        
        // Listar customers
        function listarCustomers() {
            const btn = $('.btn-info');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Listando...');
            btn.prop('disabled', true);
            
            $.ajax({
                url: '{{ route("assas.listar-customers") }}',
                method: 'GET',
                success: function(response) {
                    if (response.success && response.data.data && response.data.data.length > 0) {
                        let html = '<div class="alert alert-success"><h6>Customers encontrados:</h6><ul>';
                        response.data.data.forEach(function(customer) {
                            html += `<li><strong>${customer.name}</strong> (${customer.email}) - ID: <code>${customer.id}</code></li>`;
                        });
                        html += '</ul></div>';
                        $('#customersList').html(html).show();
                    } else {
                        $('#customersList').html('<div class="alert alert-warning">Nenhum customer encontrado.</div>').show();
                    }
                },
                error: function(xhr) {
                    let message = 'Erro desconhecido';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    $('#customersList').html(`<div class="alert alert-danger">Erro: ${message}</div>`).show();
                },
                complete: function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }
            });
        }
        
        // Criar customer de teste
        function criarCustomerTeste() {
            const btn = $('.btn-warning');
            const originalText = btn.html();
            btn.html('<i class="fas fa-spinner fa-spin"></i> Criando...');
            btn.prop('disabled', true);
            
            const dados = {
                name: 'Marcelo Henrique Almeida',
                email: 'marcelo.almeida@gmail.com',
                cpfCnpj: '24971563792',
                phone: '4738010919',
                mobilePhone: '47998781877',
                postalCode: '89223005',
                addressNumber: '277'
            };
            
            $.ajax({
                url: '{{ route("assas.criar-customer") }}',
                method: 'POST',
                data: dados,
                success: function(response) {
                    if (response.success) {
                        const customerId = response.data.id;
                        $('#customerCriado').html(`
                            <div class="alert alert-success">
                                <h6>✅ Customer criado com sucesso!</h6>
                                <p><strong>ID:</strong> <code>${customerId}</code></p>
                                <p><strong>Nome:</strong> ${response.data.name}</p>
                                <p><strong>E-mail:</strong> ${response.data.email}</p>
                                <hr>
                                <p><small>Copie o ID acima e cole no campo "Customer ID" do formulário de pagamento!</small></p>
                            </div>
                        `).show();
                        
                        // Atualizar o campo customer ID automaticamente
                        document.getElementById('customer').value = customerId;
                    } else {
                        $('#customerCriado').html(`<div class="alert alert-danger">Erro: ${response.message}</div>`).show();
                    }
                },
                error: function(xhr) {
                    let message = 'Erro desconhecido';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    $('#customerCriado').html(`<div class="alert alert-danger">Erro: ${message}</div>`).show();
                },
                complete: function() {
                    btn.html(originalText);
                    btn.prop('disabled', false);
                }
            });
        }
    </script>
</body>
</html>
