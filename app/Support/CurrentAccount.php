<?php


namespace App\Support;

use App\Models\Account;


class CurrentAccount {
    public ?Account $account = null;
    public function __construct(?Account $account = null) { $this->account = $account; }
    public function set(?Account $a): void { $this->account = $a; }
    public function id(): ?int { return $this->account?->id; }
    public function get(): ?Account { return $this->account; }
}
