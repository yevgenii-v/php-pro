<?php

namespace App\Services\TelegramWeb\Handlers\UpdateBook;

use App\Enums\Lang;
use Illuminate\Support\Facades\Redis;

class UpdateBookTelegramStorage
{
    private const BOOK_ID = 'update-book-id';
    private const BOOK_NAME = 'update-book-name';
    private const BOOK_YEAR = 'update-book-year';
    private const BOOK_LANG = 'update-book-lang';
    private const BOOK_PAGES = 'update-book-pages';
    private const BOOK_CATEGORY_ID = 'update-book-categoryId';

    public function deletePrevBook(int $senderId): void
    {
        Redis::del(
            $senderId . self::BOOK_ID,
            $senderId . self::BOOK_NAME,
            $senderId . self::BOOK_YEAR,
            $senderId . self::BOOK_LANG,
            $senderId . self::BOOK_PAGES,
            $senderId . self::BOOK_CATEGORY_ID,
        );
    }

    /**
     * @param int $senderId
     * @return bool
     */
    public function isIdNotExists(int $senderId): bool
    {
        return Redis::exists($senderId . self::BOOK_ID) === 0;
    }

    /**
     * @param int $senderId
     * @param int $value
     * @return void
     */
    public function setId(int $senderId, int $value): void
    {
        Redis::set($senderId . self::BOOK_ID, $value);
    }

    /**
     * @param int $senderId
     * @return int
     */
    public function getId(int $senderId): int
    {
        return Redis::get($senderId . self::BOOK_ID);
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
     * @return string
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
     * @param int $senderId
     * @return Lang
     */
    public function getLang(int $senderId): Lang
    {
        return Lang::from(Redis::get($senderId . self::BOOK_LANG));
    }

    /**
     * @param int $senderId
     * @return bool
     */
    public function isPagesNotExists(int $senderId): bool
    {
        return Redis::exists($senderId . self::BOOK_PAGES) === 0;
    }

    /**
     * @param int $senderId
     * @param int $value
     * @return void
     */
    public function setPages(int $senderId, int $value): void
    {
        Redis::set($senderId . self::BOOK_PAGES, $value);
    }

    /**
     * @param int $senderId
     * @return int
     */
    public function getPages(int $senderId): int
    {
        return Redis::get($senderId . self::BOOK_PAGES);
    }
}
