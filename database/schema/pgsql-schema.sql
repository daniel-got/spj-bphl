--
-- PostgreSQL database dump
--

\restrict KLAd88dYRclQuVzdAByWHrUS9pFMlGNjhPsDoAQ3BY93lA56DB21ZQ74BLsd99f

-- Dumped from database version 17.9
-- Dumped by pg_dump version 18.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'SQL_ASCII';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration bigint NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration bigint NOT NULL
);


--
-- Name: data_pegawai; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.data_pegawai (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    nama_pegawai character varying(255) NOT NULL,
    nip character varying(255) NOT NULL,
    pangkat character varying(255),
    golongan character varying(255),
    jabatan character varying(255),
    sub_seksi character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: data_pegawai_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.data_pegawai_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: data_pegawai_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.data_pegawai_id_seq OWNED BY public.data_pegawai.id;


--
-- Name: data_rincian; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.data_rincian (
    id bigint NOT NULL,
    status character varying(255) DEFAULT 'draft'::character varying NOT NULL,
    pembuat_id bigint NOT NULL,
    verifikator_id bigint,
    catatan_verifikator text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    rincian_biaya json,
    spd_id bigint,
    lampiran character varying(255),
    CONSTRAINT data_rincian_status_check CHECK (((status)::text = ANY ((ARRAY['draft'::character varying, 'diajukan'::character varying, 'direvisi'::character varying, 'disetujui'::character varying, 'ditolak'::character varying])::text[])))
);


--
-- Name: data_rincian_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.data_rincian_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: data_rincian_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.data_rincian_id_seq OWNED BY public.data_rincian.id;


--
-- Name: data_spd; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.data_spd (
    id bigint NOT NULL,
    nomor_spd character varying(255) NOT NULL,
    tgl_spd date NOT NULL,
    nip_pegawai character varying(255) NOT NULL,
    jenis_perjalanan character varying(255) NOT NULL,
    berangkat_dari character varying(255) NOT NULL,
    alat_angkut character varying(255),
    ppk character varying(255),
    nama_ppk character varying(255),
    nip_ppk character varying(255),
    pejabat_ditugaskan json,
    pembuat_id bigint NOT NULL,
    verifikator_id bigint,
    catatan_verifikator text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    spt_id bigint,
    kepala_seksi_jabatan character varying(255),
    kepala_seksi_nama character varying(255),
    kepala_seksi_nip character varying(255),
    pejabat_instansi_perusahaan character varying(255),
    pejabat_instansi_perusahaan_nama character varying(255),
    pejabat_instansi_perusahaan_nip character varying(255),
    destinasi json
);


--
-- Name: data_spd_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.data_spd_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: data_spd_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.data_spd_id_seq OWNED BY public.data_spd.id;


--
-- Name: data_spt; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.data_spt (
    id bigint NOT NULL,
    nomor_spt character varying(255) NOT NULL,
    tgl_spt date NOT NULL,
    surat_dasar text,
    pegawai_ditugaskan json NOT NULL,
    tujuan_kegiatan text NOT NULL,
    tempat_tujuan character varying(255) NOT NULL,
    tgl_berangkat date NOT NULL,
    tgl_kembali date NOT NULL,
    lama_kegiatan integer NOT NULL,
    kode_mak character varying(255) NOT NULL,
    status character varying(255) DEFAULT 'draft'::character varying NOT NULL,
    pembuat_id bigint NOT NULL,
    verifikator_id bigint,
    catatan_verifikator text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    penanggung_jawab character varying(255),
    anggota text,
    menimbang text,
    dasar text,
    biaya text,
    jenis_tugas character varying(255),
    CONSTRAINT data_spt_status_check CHECK (((status)::text = ANY ((ARRAY['draft'::character varying, 'diajukan'::character varying, 'direvisi'::character varying, 'disetujui'::character varying, 'ditolak'::character varying])::text[])))
);


--
-- Name: data_spt_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.data_spt_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: data_spt_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.data_spt_id_seq OWNED BY public.data_spt.id;


--
-- Name: data_surat_dasar; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.data_surat_dasar (
    id bigint NOT NULL,
    teks text NOT NULL,
    aktif boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    jenis_spt character varying(255)
);


--
-- Name: data_surat_dasar_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.data_surat_dasar_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: data_surat_dasar_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.data_surat_dasar_id_seq OWNED BY public.data_surat_dasar.id;


--
-- Name: data_uang_harian; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.data_uang_harian (
    id bigint NOT NULL,
    provinsi character varying(255) NOT NULL,
    luar_kota integer DEFAULT 0 NOT NULL,
    dalam_kota_lebih_8_jam integer DEFAULT 0 NOT NULL,
    diklat integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: data_uang_harian_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.data_uang_harian_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: data_uang_harian_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.data_uang_harian_id_seq OWNED BY public.data_uang_harian.id;


--
-- Name: data_uang_penginapan; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.data_uang_penginapan (
    id bigint NOT NULL,
    provinsi character varying(255) NOT NULL,
    gol_iv bigint DEFAULT '0'::bigint NOT NULL,
    gol_iii_ii_i bigint DEFAULT '0'::bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: data_uang_penginapan_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.data_uang_penginapan_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: data_uang_penginapan_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.data_uang_penginapan_id_seq OWNED BY public.data_uang_penginapan.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection character varying(255) NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    roles jsonb DEFAULT '["user"]'::jsonb NOT NULL
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: data_pegawai id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_pegawai ALTER COLUMN id SET DEFAULT nextval('public.data_pegawai_id_seq'::regclass);


--
-- Name: data_rincian id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_rincian ALTER COLUMN id SET DEFAULT nextval('public.data_rincian_id_seq'::regclass);


--
-- Name: data_spd id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spd ALTER COLUMN id SET DEFAULT nextval('public.data_spd_id_seq'::regclass);


--
-- Name: data_spt id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spt ALTER COLUMN id SET DEFAULT nextval('public.data_spt_id_seq'::regclass);


--
-- Name: data_surat_dasar id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_surat_dasar ALTER COLUMN id SET DEFAULT nextval('public.data_surat_dasar_id_seq'::regclass);


--
-- Name: data_uang_harian id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_uang_harian ALTER COLUMN id SET DEFAULT nextval('public.data_uang_harian_id_seq'::regclass);


--
-- Name: data_uang_penginapan id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_uang_penginapan ALTER COLUMN id SET DEFAULT nextval('public.data_uang_penginapan_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: data_pegawai data_pegawai_nip_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_pegawai
    ADD CONSTRAINT data_pegawai_nip_unique UNIQUE (nip);


--
-- Name: data_pegawai data_pegawai_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_pegawai
    ADD CONSTRAINT data_pegawai_pkey PRIMARY KEY (id);


--
-- Name: data_rincian data_rincian_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_rincian
    ADD CONSTRAINT data_rincian_pkey PRIMARY KEY (id);


--
-- Name: data_spd data_spd_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spd
    ADD CONSTRAINT data_spd_pkey PRIMARY KEY (id);


--
-- Name: data_spt data_spt_nomor_spt_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spt
    ADD CONSTRAINT data_spt_nomor_spt_unique UNIQUE (nomor_spt);


--
-- Name: data_spt data_spt_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spt
    ADD CONSTRAINT data_spt_pkey PRIMARY KEY (id);


--
-- Name: data_surat_dasar data_surat_dasar_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_surat_dasar
    ADD CONSTRAINT data_surat_dasar_pkey PRIMARY KEY (id);


--
-- Name: data_surat_dasar data_surat_dasar_teks_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_surat_dasar
    ADD CONSTRAINT data_surat_dasar_teks_unique UNIQUE (teks);


--
-- Name: data_uang_harian data_uang_harian_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_uang_harian
    ADD CONSTRAINT data_uang_harian_pkey PRIMARY KEY (id);


--
-- Name: data_uang_harian data_uang_harian_provinsi_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_uang_harian
    ADD CONSTRAINT data_uang_harian_provinsi_unique UNIQUE (provinsi);


--
-- Name: data_uang_penginapan data_uang_penginapan_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_uang_penginapan
    ADD CONSTRAINT data_uang_penginapan_pkey PRIMARY KEY (id);


--
-- Name: data_uang_penginapan data_uang_penginapan_provinsi_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_uang_penginapan
    ADD CONSTRAINT data_uang_penginapan_provinsi_unique UNIQUE (provinsi);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: failed_jobs_connection_queue_failed_at_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX failed_jobs_connection_queue_failed_at_index ON public.failed_jobs USING btree (connection, queue, failed_at);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: data_pegawai data_pegawai_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_pegawai
    ADD CONSTRAINT data_pegawai_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: data_rincian data_rincian_pembuat_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_rincian
    ADD CONSTRAINT data_rincian_pembuat_id_foreign FOREIGN KEY (pembuat_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: data_rincian data_rincian_spd_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_rincian
    ADD CONSTRAINT data_rincian_spd_id_foreign FOREIGN KEY (spd_id) REFERENCES public.data_spd(id) ON DELETE CASCADE;


--
-- Name: data_rincian data_rincian_verifikator_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_rincian
    ADD CONSTRAINT data_rincian_verifikator_id_foreign FOREIGN KEY (verifikator_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: data_spd data_spd_pembuat_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spd
    ADD CONSTRAINT data_spd_pembuat_id_foreign FOREIGN KEY (pembuat_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: data_spd data_spd_spt_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spd
    ADD CONSTRAINT data_spd_spt_id_foreign FOREIGN KEY (spt_id) REFERENCES public.data_spt(id) ON DELETE SET NULL;


--
-- Name: data_spd data_spd_verifikator_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spd
    ADD CONSTRAINT data_spd_verifikator_id_foreign FOREIGN KEY (verifikator_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: data_spt data_spt_pembuat_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spt
    ADD CONSTRAINT data_spt_pembuat_id_foreign FOREIGN KEY (pembuat_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: data_spt data_spt_verifikator_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.data_spt
    ADD CONSTRAINT data_spt_verifikator_id_foreign FOREIGN KEY (verifikator_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

\unrestrict KLAd88dYRclQuVzdAByWHrUS9pFMlGNjhPsDoAQ3BY93lA56DB21ZQ74BLsd99f

--
-- PostgreSQL database dump
--

\restrict lR2h5diIFx205eOdNZWx5eXRgJt8wvqeGtjHlwfTdWKgbbNWbN8UxRS4IQFQhow

-- Dumped from database version 17.9
-- Dumped by pg_dump version 18.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'SQL_ASCII';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_06_25_050116_create_data_spt_table	1
5	2026_06_25_050159_create_data_spd_table	1
6	2026_06_25_050232_create_data_rincian_table	1
7	2026_06_25_062958_create_data_pegawai_table	1
8	2026_07_01_022232_add_spt_id_to_data_spd_table	1
9	2026_07_05_152255_modify_biaya_columns_on_data_rincian_table	1
10	2026_07_08_014646_add_pembuat_spt_to_users_role_enum	1
11	2026_07_08_015105_add_user_id_to_data_pegawai_table	1
12	2026_07_08_020548_add_status_and_pembuat_id_to_data_spt_table	1
13	2026_07_08_173417_normalize_spd_and_rincian_tables	1
14	2026_07_08_174914_add_lampiran_to_data_rincian_table	1
15	2026_07_08_175133_add_roles_to_data_spt_table	1
16	2026_07_09_014351_change_anggota_type_in_data_spt_table	1
17	2026_07_09_025713_add_spt_extra_fields_to_data_spt_table	1
18	2026_07_09_052055_remove_status_from_data_spd_table	1
19	2026_07_09_092354_create_uang_harians_table	1
20	2026_07_13_035442_add_jenis_and_dasar_to_data_spt_table	1
21	2026_07_13_063420_create_uang_penginapans_table	1
22	2026_07_13_075134_add_surat_dasar_to_data_spt_table	1
23	2026_07_13_093920_create_surat_dasars_table	1
24	2026_07_13_095707_modify_role_to_roles_json_on_users_table	1
25	2026_07_20_035707_drop_unique_nomor_spd_from_data_spd_table	1
26	2026_07_20_075739_add_kepala_and_pejabat_to_data_spd_table	1
27	2026_07_21_182641_add_destinasi_to_data_spd_table	2
28	2026_07_21_083658_add_jenis_spt_to_data_surat_dasar_table	3
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 28, true);


--
-- PostgreSQL database dump complete
--

\unrestrict lR2h5diIFx205eOdNZWx5eXRgJt8wvqeGtjHlwfTdWKgbbNWbN8UxRS4IQFQhow

