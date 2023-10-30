<?php

namespace App\Enums;

enum TelegramCommands: string
{
    case INFO = '/info';
    case LOAD_BOOKS = '/loadBooks';
    case DOWNLOAD_FILE = '/downloadFile';
    case CREATE_BOOK = '/createBook';
    case UPDATE_BOOK = '/updateBook';
    case DELETE_BOOK = '/deleteBook';
    case SHOW_BOOK = '/showBook';
}
