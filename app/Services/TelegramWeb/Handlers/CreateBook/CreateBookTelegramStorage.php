<?php

namespace App\Services\TelegramWeb\Handlers\CreateBook;

use App\Enums\Lang;
use Illuminate\Support\Facades\Redis;

class CreateBookTelegramStorage
{
    private const BOOK_NAME = 'create-book-name';
    private const BOOK_YEAR = 'create-book-year';
    private const BOOK_LANG = 'create-book-lang';
    private const BOOK_PAGES = 'create-book-pages';

    /**
     * @param int $senderId
     * @return void
     */
    public function deletePrevBook(int $senderId): void
    {
        Redis::del(
            $senderId . self::BOOK_NAME,
            $senderId . self::BOOK_YEAR,
            $senderId . self::BOOK_LANG,
            $senderId . self::BOOK_PAGES,
        );
    }

    /**
     * @param int $senderId
     * @return bool
     */
    public function isNameNotExists(int $senderId): bool
    {
        return Redis::exists($senderId . self::BOOK_NAME) === 0;
    }

    /**
     * @param int $senderId
     * @param string $value
     * @return void
     */
    public function setName(int $senderId, string $value): void
    {
        Redis::set($senderId . self::BOOK_NAME, $value);
    }

    /**
     * @param int $senderId
     * @return mixed
     */
    public function getName(int $senderId): string
    {
        return Redis::get($senderId . self::BOOK_NAME);
    }

    /**
     * @param int $senderId
     * @return bool
     */
    public function isYearNotExists(int $senderId): bool
    {
        return Redis::exists($senderId . self::BOOK_YEAR) === 0;
    }

    /**
     * @param int $senderId
     * @param int $value
     * @return void
     */
    public function setYear(int $senderId, int $value): void
    {
        Redis::set($senderId . self::BOOK_YEAR, $value);
    }

    /**
     * @param int $senderId
     * @return int
     */
    public function getYear(int $senderId): int
    {
        return Redis::get($senderId . self::BOOK_YEAR);
    }

    /**
     * @param int $senderId
     * @return bool
     */
    public function isLangNotExists(int $senderId): bool
    {
        return Redis::exists($senderId . self::BOOK_LANG) === 0;
    }

    /**
     * @param int $senderId
     * @param string $value
     * @return void
     */
    public function setLang(int $senderId, string $value): void
    {
        Redis::set($senderId . self::BOOK_LANG, $value);
    }

    /**
     * @param string $senderId
     * @return Lang
     */
    public function getLang(string $senderId): Lang
    {
        return Lang::from(Redis::get($senderId . self::BOOK_LANG));
    }

    public function isPagesNotExists(int $senderId): bool
    {
        return Redis::exists($senderId . self::BOOK_PAGES) === 0;
    }

    public function setPages(int $senderId, int $value): void
    {
        Redis::set($senderId . self::BOOK_PAGES, $value);
    }

    public function getPages(int $senderId): int
    {
        return Redis::get($senderId . self::BOOK_PAGES);
    }
}
