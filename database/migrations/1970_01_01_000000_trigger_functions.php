<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class TriggerFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE FUNCTION keep_ord() RETURNS TRIGGER AS $$
        DECLARE
            query text;
        BEGIN
            IF TG_OP = 'DELETE' OR NEW.parent_id != OLD.parent_id THEN
                query := format('UPDATE %I
                SET ord = ord - 1
                WHERE parent_id = $1.parent_id
                AND ord > $1.ord', TG_TABLE_NAME);
                EXECUTE query USING OLD;
            END IF;
            IF TG_OP = 'DELETE' THEN
                RETURN OLD;
            end if;
            RETURN NEW;
        END
        $$ LANGUAGE 'plpgsql';");

        DB::statement("CREATE OR REPLACE FUNCTION new_ord() RETURNS TRIGGER AS $$
        DECLARE
            query text;
            max_ord integer;
        BEGIN
            IF TG_OP = 'INSERT' OR NEW.parent_id != OLD.parent_id THEN
                query := format('SELECT MAX(ord) FROM %I
                WHERE parent_id = $1.parent_id', TG_TABLE_NAME);
                EXECUTE query INTO max_ord USING NEW;

                IF (max_ord IS NULL) THEN
                    max_ord = 0;
                END IF;

                NEW.ord = max_ord + 1;
            END IF;
            RETURN NEW;
        END
        $$ LANGUAGE 'plpgsql';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP FUNCTION IF EXISTS keep_ord");
        DB::statement("DROP FUNCTION IF EXISTS new_ord");
    }
}
