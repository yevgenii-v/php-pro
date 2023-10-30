<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('new_books', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->integer('year');
            $table->enum('lang', ['en', 'ua', 'pl', 'de']);
            $table->integer('pages');
            $table->bigInteger('category_id');
            $table->timestamps();
        });

        DB::unprepared('
            CREATE OR REPLACE FUNCTION after_insert_new_book()
                RETURNS TRIGGER AS
            $$
            BEGIN
                INSERT INTO new_books (name, year, lang, pages, category_id, created_at, updated_at)
                VALUES (NEW.name, NEW.year, NEW.lang, NEW.pages, NEW.category_id, NEW.created_at, NEW.updated_at);

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER new_book
                after INSERT
                ON books
                FOR EACH ROW
            EXECUTE FUNCTION after_insert_new_book();


            CREATE OR REPLACE FUNCTION after_update_book()
                RETURNS TRIGGER AS
            $$
            BEGIN
                UPDATE new_books
                SET name        = NEW.name,
                    year        = NEW.year,
                    lang        = NEW.lang,
                    pages       = NEW.pages,
                    category_id = NEW.category_id,
                    updated_at  = NEW.updated_at
                WHERE id = NEW.id;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER update_replace
                AFTER UPDATE ON books
                FOR EACH ROW
            EXECUTE FUNCTION after_update_book();


            CREATE OR REPLACE FUNCTION after_delete_book()
                RETURNS TRIGGER AS
            $$
            BEGIN
                DELETE FROM new_books
                WHERE id = NEW.id;
                return new;
            END;
            $$ LANGUAGE plpgsql;

            CREATE TRIGGER delete_replace
                AFTER DELETE ON books
                FOR EACH ROW
            EXECUTE FUNCTION after_delete_book();
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_books');

        DB::unprepared('
            DROP TRIGGER delete_replace ON books;
            DROP FUNCTION after_delete_book();

            DROP TRIGGER update_replace ON books;
            DROP FUNCTION after_update_book();

            DROP TRIGGER new_book ON books;
            DROP FUNCTION after_insert_new_book();
        ');
    }
};
