<?php
// routes/chatbot.php
use App\Http\Controllers\Api\ChatbotController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/chatbot')->name('chatbot.')->group(function () {
    // Recherche principale
    Route::post('/search', [ChatbotController::class, 'search'])->name('search');

    // Intent handling
    Route::post('/intent/{intent}', [ChatbotController::class, 'handleIntent'])->name('intent');

    // Suggestions
    Route::get('/suggestions', [ChatbotController::class, 'getSuggestions'])->name('suggestions');

    // Quick actions
    Route::get('/quick-actions', [ChatbotController::class, 'getQuickActions'])->name('quick-actions');

    // Dynamic options
    Route::get('/modules/{module}/intents/{intent}/options/{slot}', [ChatbotController::class, 'getDynamicOptions'])
        ->name('dynamic-options');

    // Gestion conversation
    Route::prefix('conversation')->group(function () {
        Route::get('/', [ChatbotController::class, 'getConversation'])->name('conversation.get');
        Route::post('/', [ChatbotController::class, 'createConversation'])->name('conversation.create');
        Route::delete('/{conversation}', [ChatbotController::class, 'deleteConversation'])->name('conversation.delete');
        Route::post('/{conversation}/message', [ChatbotController::class, 'addMessage'])->name('conversation.message.add');
    });

    // Administration (si besoin)
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::get('/modules', [ChatbotController::class, 'listModules'])->name('modules.list');
        Route::put('/modules/{module}/config', [ChatbotController::class, 'updateModuleConfig'])->name('modules.config.update');
        Route::post('/cache/clear', [ChatbotController::class, 'clearCache'])->name('cache.clear');
        Route::get('/stats', [ChatbotController::class, 'getStats'])->name('stats');
    });
});
