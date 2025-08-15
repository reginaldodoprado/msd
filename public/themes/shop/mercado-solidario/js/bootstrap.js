/**
 * Bootstrap do tema Mercado Solidário
 * Arquivo de inicialização e configuração básica
 */

// Importar dependências necessárias
import axios from 'axios';

// Configurar axios para requisições
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configurações globais do tema
window.MercadoSolidarioConfig = {
    theme: 'mercado-solidario',
    version: '1.0.0',
    features: {
        donations: true,
        productCategories: true,
        charityAlerts: true,
        animations: true,
        responsive: true
    },
    colors: {
        primary: '#0ea5e9',
        secondary: '#FFD700',
        success: '#10B981',
        warning: '#F59E0B',
        error: '#EF4444'
    }
};

// Função de inicialização global
window.initMercadoSolidario = function() {
    console.log('🚀 Inicializando Mercado Solidário...');
    
    // Verificar se o DOM está pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeTheme);
    } else {
        initializeTheme();
    }
};

// Função principal de inicialização
function initializeTheme() {
    try {
        // Adicionar classes ao body
        document.body.classList.add('mercado-solidario-theme');
        document.body.classList.add('charity-focused');
        
        // Inicializar funcionalidades básicas
        setupThemeElements();
        setupEventListeners();
        
        console.log('✅ Mercado Solidário inicializado com sucesso!');
        
        // Disparar evento de inicialização
        window.dispatchEvent(new CustomEvent('mercado-solidario:initialized'));
        
    } catch (error) {
        console.error('❌ Erro ao inicializar Mercado Solidário:', error);
    }
}

// Configurar elementos do tema
function setupThemeElements() {
    // Adicionar container de alertas se não existir
    if (!document.getElementById('charity-alerts')) {
        const alertContainer = document.createElement('div');
        alertContainer.id = 'charity-alerts';
        alertContainer.className = 'fixed top-4 right-4 z-50 max-w-sm';
        document.body.appendChild(alertContainer);
    }
    
    // Adicionar indicador de carregamento
    if (!document.getElementById('charity-loader')) {
        const loader = document.createElement('div');
        loader.id = 'charity-loader';
        loader.className = 'fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50';
        loader.innerHTML = `
            <div class="text-center">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-charity-gold mx-auto mb-4"></div>
                <p class="text-lg font-semibold text-charity-gold">Carregando Mercado Solidário...</p>
            </div>
        `;
        document.body.appendChild(loader);
        
        // Remover loader após carregamento
        setTimeout(() => {
            if (loader.parentElement) {
                loader.remove();
            }
        }, 1000);
    }
}

// Configurar event listeners globais
function setupEventListeners() {
    // Listener para mudanças de tema
    document.addEventListener('theme:changed', function(e) {
        console.log('Tema alterado para:', e.detail.theme);
    });
    
    // Listener para doações
    document.addEventListener('donation:completed', function(e) {
        console.log('Doação realizada:', e.detail);
        showCharityAlert('Obrigado pela sua doação! Deus abençoe seu coração.', 'success');
    });
    
    // Listener para produtos
    document.addEventListener('product:viewed', function(e) {
        console.log('Produto visualizado:', e.detail);
    });
}

// Função para mostrar alertas de caridade
window.showCharityAlert = function(message, type = 'info', duration = 5000) {
    const alertContainer = document.getElementById('charity-alerts');
    if (!alertContainer) return;
    
    const alert = document.createElement('div');
    alert.className = `alert-charity alert-${type} mb-4 animate-slide-up`;
    alert.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${getAlertIcon(type)}</span>
            <span>${message}</span>
            <button class="ml-auto text-lg hover:text-neutral-600" onclick="this.parentElement.parentElement.remove()">
                ×
            </button>
        </div>
    `;
    
    alertContainer.appendChild(alert);
    
    // Auto-remover após duração especificada
    setTimeout(() => {
        if (alert.parentElement) {
            alert.remove();
        }
    }, duration);
};

// Função para obter ícones de alerta
function getAlertIcon(type) {
    const icons = {
        success: '✅',
        warning: '⚠️',
        error: '❌',
        info: 'ℹ️'
    };
    return icons[type] || icons.info;
}

// Função para verificar se o tema está ativo
window.isMercadoSolidarioActive = function() {
    return document.body.classList.contains('mercado-solidario-theme');
};

// Função para obter configurações do tema
window.getMercadoSolidarioConfig = function() {
    return window.MercadoSolidarioConfig;
};

// Inicializar automaticamente quando o arquivo for carregado
window.initMercadoSolidario();

// Exportar para uso em outros módulos
export { initializeTheme, setupThemeElements, setupEventListeners };
