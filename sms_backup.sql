--
-- PostgreSQL database dump
--

\restrict E2Kn8dl8nFqNTT7CkZRb9fmKWyp2hZfAwya9eaCNCPSgYd13fFEHKdeicMHHPGf

-- Dumped from database version 18.3
-- Dumped by pg_dump version 18.3

-- Started on 2026-06-21 01:22:40

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 234 (class 1259 OID 24776)
-- Name: attempt_answers; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.attempt_answers (
    answer_id integer NOT NULL,
    attempt_id integer,
    question_id integer,
    selected_answer character(1),
    is_correct boolean
);


ALTER TABLE public.attempt_answers OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 24775)
-- Name: attempt_answers_answer_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.attempt_answers_answer_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.attempt_answers_answer_id_seq OWNER TO postgres;

--
-- TOC entry 5140 (class 0 OID 0)
-- Dependencies: 233
-- Name: attempt_answers_answer_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.attempt_answers_answer_id_seq OWNED BY public.attempt_answers.answer_id;


--
-- TOC entry 228 (class 1259 OID 24723)
-- Name: learning_progress; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.learning_progress (
    progress_id integer NOT NULL,
    user_id integer,
    topic_id integer,
    last_section integer,
    progress_percent integer DEFAULT 0,
    last_opened timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    last_page integer DEFAULT 1,
    total_pages integer DEFAULT 1,
    highest_page integer DEFAULT 1
);


ALTER TABLE public.learning_progress OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 24722)
-- Name: learning_progress_progress_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.learning_progress_progress_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.learning_progress_progress_id_seq OWNER TO postgres;

--
-- TOC entry 5141 (class 0 OID 0)
-- Dependencies: 227
-- Name: learning_progress_progress_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.learning_progress_progress_id_seq OWNED BY public.learning_progress.progress_id;


--
-- TOC entry 238 (class 1259 OID 32912)
-- Name: lesson_sections; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lesson_sections (
    section_id integer NOT NULL,
    topic_id integer,
    section_no integer,
    title character varying(255),
    explanation text,
    example_text text,
    tip_text text,
    warning_text text,
    activity_text text
);


ALTER TABLE public.lesson_sections OWNER TO postgres;

--
-- TOC entry 237 (class 1259 OID 32911)
-- Name: lesson_sections_section_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lesson_sections_section_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lesson_sections_section_id_seq OWNER TO postgres;

--
-- TOC entry 5142 (class 0 OID 0)
-- Dependencies: 237
-- Name: lesson_sections_section_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lesson_sections_section_id_seq OWNED BY public.lesson_sections.section_id;


--
-- TOC entry 226 (class 1259 OID 24708)
-- Name: notes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.notes (
    note_id integer NOT NULL,
    topic_id integer,
    section_no integer,
    title character varying(100),
    content text,
    file_data bytea
);


ALTER TABLE public.notes OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 24707)
-- Name: notes_note_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.notes_note_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.notes_note_id_seq OWNER TO postgres;

--
-- TOC entry 5143 (class 0 OID 0)
-- Dependencies: 225
-- Name: notes_note_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.notes_note_id_seq OWNED BY public.notes.note_id;


--
-- TOC entry 230 (class 1259 OID 24742)
-- Name: questions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.questions (
    question_id integer NOT NULL,
    topic_id integer,
    question_text text,
    option_a text,
    option_b text,
    option_c text,
    option_d text,
    correct_answer character(1),
    difficulty character varying(20),
    is_diagnostic boolean DEFAULT false
);


ALTER TABLE public.questions OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 24741)
-- Name: questions_question_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.questions_question_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.questions_question_id_seq OWNER TO postgres;

--
-- TOC entry 5144 (class 0 OID 0)
-- Dependencies: 229
-- Name: questions_question_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.questions_question_id_seq OWNED BY public.questions.question_id;


--
-- TOC entry 232 (class 1259 OID 24757)
-- Name: quiz_attempt; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.quiz_attempt (
    attempt_id integer NOT NULL,
    user_id integer,
    topic_id integer,
    score integer,
    attempt_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.quiz_attempt OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 24756)
-- Name: quiz_attempt_attempt_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.quiz_attempt_attempt_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.quiz_attempt_attempt_id_seq OWNER TO postgres;

--
-- TOC entry 5145 (class 0 OID 0)
-- Dependencies: 231
-- Name: quiz_attempt_attempt_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.quiz_attempt_attempt_id_seq OWNED BY public.quiz_attempt.attempt_id;


--
-- TOC entry 240 (class 1259 OID 32933)
-- Name: subject_diagnostic; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subject_diagnostic (
    diagnostic_id integer NOT NULL,
    user_id integer,
    subject_id integer,
    score integer DEFAULT 0,
    total integer DEFAULT 0,
    level character varying(20),
    recommended_topic_id integer,
    completed_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.subject_diagnostic OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 32932)
-- Name: subject_diagnostic_diagnostic_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subject_diagnostic_diagnostic_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subject_diagnostic_diagnostic_id_seq OWNER TO postgres;

--
-- TOC entry 5146 (class 0 OID 0)
-- Dependencies: 239
-- Name: subject_diagnostic_diagnostic_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subject_diagnostic_diagnostic_id_seq OWNED BY public.subject_diagnostic.diagnostic_id;


--
-- TOC entry 222 (class 1259 OID 24687)
-- Name: subjects; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.subjects (
    subject_id integer NOT NULL,
    subject_name character varying(100)
);


ALTER TABLE public.subjects OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 24686)
-- Name: subjects_subject_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.subjects_subject_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subjects_subject_id_seq OWNER TO postgres;

--
-- TOC entry 5147 (class 0 OID 0)
-- Dependencies: 221
-- Name: subjects_subject_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.subjects_subject_id_seq OWNED BY public.subjects.subject_id;


--
-- TOC entry 236 (class 1259 OID 32903)
-- Name: topic_completion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.topic_completion (
    completion_id integer NOT NULL,
    user_id integer,
    topic_id integer,
    status character varying(30),
    completed_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.topic_completion OWNER TO postgres;

--
-- TOC entry 235 (class 1259 OID 32902)
-- Name: topic_completion_completion_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.topic_completion_completion_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.topic_completion_completion_id_seq OWNER TO postgres;

--
-- TOC entry 5148 (class 0 OID 0)
-- Dependencies: 235
-- Name: topic_completion_completion_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.topic_completion_completion_id_seq OWNED BY public.topic_completion.completion_id;


--
-- TOC entry 224 (class 1259 OID 24695)
-- Name: topics; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.topics (
    topic_id integer NOT NULL,
    subject_id integer,
    topic_name character varying(100)
);


ALTER TABLE public.topics OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 24694)
-- Name: topics_topic_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.topics_topic_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.topics_topic_id_seq OWNER TO postgres;

--
-- TOC entry 5149 (class 0 OID 0)
-- Dependencies: 223
-- Name: topics_topic_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.topics_topic_id_seq OWNED BY public.topics.topic_id;


--
-- TOC entry 220 (class 1259 OID 24674)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    name character varying(100),
    email character varying(100),
    password text,
    role character varying(20) DEFAULT 'student'::character varying,
    diagnostic_done boolean DEFAULT false,
    diagnostic_score integer DEFAULT 0,
    diagnostic_total integer DEFAULT 0,
    recommended_topic_id integer,
    diagnostic_level character varying(20),
    current_level character varying(20) DEFAULT 'Weak'::character varying
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 24673)
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_user_id_seq OWNER TO postgres;

--
-- TOC entry 5150 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_user_id_seq OWNED BY public.users.user_id;


--
-- TOC entry 4925 (class 2604 OID 24779)
-- Name: attempt_answers answer_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attempt_answers ALTER COLUMN answer_id SET DEFAULT nextval('public.attempt_answers_answer_id_seq'::regclass);


--
-- TOC entry 4915 (class 2604 OID 24726)
-- Name: learning_progress progress_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.learning_progress ALTER COLUMN progress_id SET DEFAULT nextval('public.learning_progress_progress_id_seq'::regclass);


--
-- TOC entry 4928 (class 2604 OID 32915)
-- Name: lesson_sections section_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lesson_sections ALTER COLUMN section_id SET DEFAULT nextval('public.lesson_sections_section_id_seq'::regclass);


--
-- TOC entry 4914 (class 2604 OID 24711)
-- Name: notes note_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notes ALTER COLUMN note_id SET DEFAULT nextval('public.notes_note_id_seq'::regclass);


--
-- TOC entry 4921 (class 2604 OID 24745)
-- Name: questions question_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questions ALTER COLUMN question_id SET DEFAULT nextval('public.questions_question_id_seq'::regclass);


--
-- TOC entry 4923 (class 2604 OID 24760)
-- Name: quiz_attempt attempt_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.quiz_attempt ALTER COLUMN attempt_id SET DEFAULT nextval('public.quiz_attempt_attempt_id_seq'::regclass);


--
-- TOC entry 4929 (class 2604 OID 32936)
-- Name: subject_diagnostic diagnostic_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subject_diagnostic ALTER COLUMN diagnostic_id SET DEFAULT nextval('public.subject_diagnostic_diagnostic_id_seq'::regclass);


--
-- TOC entry 4912 (class 2604 OID 24690)
-- Name: subjects subject_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subjects ALTER COLUMN subject_id SET DEFAULT nextval('public.subjects_subject_id_seq'::regclass);


--
-- TOC entry 4926 (class 2604 OID 32906)
-- Name: topic_completion completion_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.topic_completion ALTER COLUMN completion_id SET DEFAULT nextval('public.topic_completion_completion_id_seq'::regclass);


--
-- TOC entry 4913 (class 2604 OID 24698)
-- Name: topics topic_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.topics ALTER COLUMN topic_id SET DEFAULT nextval('public.topics_topic_id_seq'::regclass);


--
-- TOC entry 4906 (class 2604 OID 24677)
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_user_id_seq'::regclass);


--
-- TOC entry 5128 (class 0 OID 24776)
-- Dependencies: 234
-- Data for Name: attempt_answers; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.attempt_answers (answer_id, attempt_id, question_id, selected_answer, is_correct) FROM stdin;
60	31	5	B	t
61	31	6	A	f
62	31	7	A	f
63	32	5	B	t
64	32	6	B	t
65	32	7	B	t
66	33	5	B	t
67	33	6	B	t
68	33	7	B	t
69	34	5	B	t
70	34	6	B	t
71	34	7	B	t
72	35	5	B	t
73	35	6	A	f
74	35	7	B	t
75	36	5	B	t
76	36	6	A	f
77	36	7	B	t
78	37	5	B	t
79	37	6	B	t
80	37	7	B	t
81	38	5	B	t
82	38	6	B	t
83	38	7	B	t
84	39	5	B	t
85	39	6	B	t
86	39	7	B	t
87	40	5	A	f
88	40	6	B	t
89	40	7	B	t
\.


--
-- TOC entry 5122 (class 0 OID 24723)
-- Dependencies: 228
-- Data for Name: learning_progress; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.learning_progress (progress_id, user_id, topic_id, last_section, progress_percent, last_opened, last_page, total_pages, highest_page) FROM stdin;
15	5	6	0	100	2026-06-15 19:19:40.33997	1	1	1
16	4	9	0	0	2026-06-15 21:16:33.046655	1	1	1
14	4	6	0	100	2026-06-15 21:16:50.174904	1	1	1
\.


--
-- TOC entry 5132 (class 0 OID 32912)
-- Dependencies: 238
-- Data for Name: lesson_sections; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lesson_sections (section_id, topic_id, section_no, title, explanation, example_text, tip_text, warning_text, activity_text) FROM stdin;
4	6	1	Introduction to Integers	Integers are positive numbers, negative numbers and zero.				
5	6	2	Section 2	Test				
\.


--
-- TOC entry 5120 (class 0 OID 24708)
-- Dependencies: 226
-- Data for Name: notes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.notes (note_id, topic_id, section_no, title, content, file_data) FROM stdin;
16	6	\N	\N	\N	\\x255044462d312e340a25938c8b9e205265706f72744c61622047656e6572617465642050444620646f63756d656e7420687474703a2f2f7777772e7265706f72746c61622e636f6d0a312030206f626a0a3c3c0a2f4631203220302052202f46322033203020520a3e3e0a656e646f626a0a322030206f626a0a3c3c0a2f42617365466f6e74202f48656c766574696361202f456e636f64696e67202f57696e416e7369456e636f64696e67202f4e616d65202f4631202f53756274797065202f5479706531202f54797065202f466f6e740a3e3e0a656e646f626a0a332030206f626a0a3c3c0a2f42617365466f6e74202f48656c7665746963612d426f6c64202f456e636f64696e67202f57696e416e7369456e636f64696e67202f4e616d65202f4632202f53756274797065202f5479706531202f54797065202f466f6e740a3e3e0a656e646f626a0a342030206f626a0a3c3c0a2f436f6e74656e7473203820302052202f4d65646961426f78205b203020302036313220373932205d202f506172656e74203720302052202f5265736f7572636573203c3c0a2f466f6e74203120302052202f50726f63536574205b202f504446202f54657874202f496d61676542202f496d61676543202f496d61676549205d0a3e3e202f526f746174652030202f5472616e73203c3c0a0a3e3e200a20202f54797065202f506167650a3e3e0a656e646f626a0a352030206f626a0a3c3c0a2f506167654d6f6465202f5573654e6f6e65202f5061676573203720302052202f54797065202f436174616c6f670a3e3e0a656e646f626a0a362030206f626a0a3c3c0a2f417574686f7220285c28616e6f6e796d6f75735c2929202f4372656174696f6e446174652028443a32303236303531353130333534312b30302730302729202f43726561746f7220285c28756e7370656369666965645c2929202f4b6579776f726473202829202f4d6f64446174652028443a32303236303531353130333534312b30302730302729202f50726f647563657220285265706f72744c616220504446204c696272617279202d207777772e7265706f72746c61622e636f6d29200a20202f5375626a65637420285c28756e7370656369666965645c2929202f5469746c6520285c28616e6f6e796d6f75735c2929202f54726170706564202f46616c73650a3e3e0a656e646f626a0a372030206f626a0a3c3c0a2f436f756e742031202f4b696473205b203420302052205d202f54797065202f50616765730a3e3e0a656e646f626a0a382030206f626a0a3c3c0a2f46696c746572205b202f415343494938354465636f6465202f466c6174654465636f6465205d202f4c656e677468203430320a3e3e0a73747265616d0a4761723f2d6323314250263b394c744d452e513939214f59374a41652d50452c29457458496160584a713a3a6325435142326d3b2632602e544071715957467244585c492f64362c486e635e6b435a5c37522f425324372b6a5e3f6e5b6e5142475a663b45665f4c623b433f587549605562726a50255d2a616e374c394b6e4143424b6937412a236a45583c6d604b402647656f6b642f6224704d3750726e24563838592c5f56425d6a4a5f66406b2c4272624230224d486f6a72262742426d4d2c6c212246214636696f6d3a6c3f665a4134435931723c4231446d5f74274b406a312f4b53363f3e6931454961624c67262d5b6b615e42573058742a692e5f4561245d282e4c69513c646d5c614f5027303927724833423364222c57566f3f5758465e2440565f405b3b4c306d357026555e4c326b22633d43685b5d6c33655b5a5946283e5c56605d3a6a29713e2f63513f4b3c4b62746c644e2172366b2474322d6e41225956704c252f3362543141495c54726261294446585253686f6f2c6f5e594e383f553d3b6c72622e4c4c7e3e656e6473747265616d0a656e646f626a0a787265660a3020390a303030303030303030302036353533352066200a30303030303030303733203030303030206e200a30303030303030313134203030303030206e200a30303030303030323231203030303030206e200a30303030303030333333203030303030206e200a30303030303030353236203030303030206e200a30303030303030353934203030303030206e200a30303030303030383737203030303030206e200a30303030303030393336203030303030206e200a747261696c65720a3c3c0a2f4944200a5b3c63316438616365323265653162623737643932306662333231333836646537323e3c63316438616365323265653162623737643932306662333231333836646537323e5d0a25205265706f72744c61622067656e6572617465642050444620646f63756d656e74202d2d206469676573742028687474703a2f2f7777772e7265706f72746c61622e636f6d290a0a2f496e666f2036203020520a2f526f6f742035203020520a2f53697a6520390a3e3e0a7374617274787265660a313432380a2525454f460a
\.


--
-- TOC entry 5124 (class 0 OID 24742)
-- Dependencies: 230
-- Data for Name: questions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.questions (question_id, topic_id, question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty, is_diagnostic) FROM stdin;
5	6	-5 + 3 = ?	-8	-2	2	8	B	\N	t
6	6	1 + 1= ?	1	2	3	4	B	\N	t
7	6	-3 × -2 = ?	-6	6	3	-3	B	\N	f
\.


--
-- TOC entry 5126 (class 0 OID 24757)
-- Dependencies: 232
-- Data for Name: quiz_attempt; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.quiz_attempt (attempt_id, user_id, topic_id, score, attempt_date) FROM stdin;
31	4	6	33	2026-06-15 18:48:07.886171
32	4	6	100	2026-06-15 18:49:44.985467
33	4	6	100	2026-06-15 18:51:19.563783
34	4	6	100	2026-06-15 18:56:51.632778
35	4	6	67	2026-06-15 19:00:13.718419
36	4	6	67	2026-06-15 19:06:22.113897
37	4	6	100	2026-06-15 19:16:33.116802
38	5	6	100	2026-06-15 19:20:10.926623
39	4	6	100	2026-06-15 21:17:36.468909
40	4	6	67	2026-06-15 21:18:16.581059
\.


--
-- TOC entry 5134 (class 0 OID 32933)
-- Dependencies: 240
-- Data for Name: subject_diagnostic; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.subject_diagnostic (diagnostic_id, user_id, subject_id, score, total, level, recommended_topic_id, completed_at) FROM stdin;
4	4	4	1	2	Good	6	2026-06-15 18:45:59.9704
5	5	4	2	2	Strong	\N	2026-06-15 19:19:30.625621
\.


--
-- TOC entry 5116 (class 0 OID 24687)
-- Dependencies: 222
-- Data for Name: subjects; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.subjects (subject_id, subject_name) FROM stdin;
4	Mathematics
6	Science
\.


--
-- TOC entry 5130 (class 0 OID 32903)
-- Dependencies: 236
-- Data for Name: topic_completion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.topic_completion (completion_id, user_id, topic_id, status, completed_at) FROM stdin;
1	5	1	mastered	2026-05-16 14:05:01.983668
2	1	1	in_progress	2026-06-13 18:20:49.163311
3	7	1	in_progress	2026-06-13 22:35:10.702847
5	2	2	mastered	2026-06-14 22:36:03.853739
4	2	1	mastered	2026-06-14 19:00:00.555018
7	5	6	mastered	2026-06-15 19:20:10.988382
6	4	6	mastered	2026-06-15 18:48:08.014686
\.


--
-- TOC entry 5118 (class 0 OID 24695)
-- Dependencies: 224
-- Data for Name: topics; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.topics (topic_id, subject_id, topic_name) FROM stdin;
6	4	Integer
7	4	Fractions
8	4	Algebraic Expressions
9	6	Human Anatomy
\.


--
-- TOC entry 5114 (class 0 OID 24674)
-- Dependencies: 220
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (user_id, name, email, password, role, diagnostic_done, diagnostic_score, diagnostic_total, recommended_topic_id, diagnostic_level, current_level) FROM stdin;
3	admin	admin@gmail.com	$2y$10$QHG/n1GBH/OnJCEEmJO4uOPouulpSPIE3xjFuZK.BFvtdr7cB83ZO	admin	f	0	0	\N	\N	Weak
5	student2	student2@gmail.com	$2y$10$tZRoPUqxaz9Aorbc4wLuYOhutgYwvqm0Aqj4xk6afVrn8CRCOKTpO	student	f	0	0	\N	\N	Strong
4	student1	student1@gmail.com	$2y$10$62uG7p2v.fjkHhq7ji1T1OADhB9tTPfBotfVAe2Af.mO4.4SceMZK	student	f	0	0	\N	\N	Good
\.


--
-- TOC entry 5151 (class 0 OID 0)
-- Dependencies: 233
-- Name: attempt_answers_answer_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.attempt_answers_answer_id_seq', 89, true);


--
-- TOC entry 5152 (class 0 OID 0)
-- Dependencies: 227
-- Name: learning_progress_progress_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.learning_progress_progress_id_seq', 16, true);


--
-- TOC entry 5153 (class 0 OID 0)
-- Dependencies: 237
-- Name: lesson_sections_section_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lesson_sections_section_id_seq', 5, true);


--
-- TOC entry 5154 (class 0 OID 0)
-- Dependencies: 225
-- Name: notes_note_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.notes_note_id_seq', 16, true);


--
-- TOC entry 5155 (class 0 OID 0)
-- Dependencies: 229
-- Name: questions_question_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.questions_question_id_seq', 7, true);


--
-- TOC entry 5156 (class 0 OID 0)
-- Dependencies: 231
-- Name: quiz_attempt_attempt_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.quiz_attempt_attempt_id_seq', 40, true);


--
-- TOC entry 5157 (class 0 OID 0)
-- Dependencies: 239
-- Name: subject_diagnostic_diagnostic_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.subject_diagnostic_diagnostic_id_seq', 5, true);


--
-- TOC entry 5158 (class 0 OID 0)
-- Dependencies: 221
-- Name: subjects_subject_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.subjects_subject_id_seq', 6, true);


--
-- TOC entry 5159 (class 0 OID 0)
-- Dependencies: 235
-- Name: topic_completion_completion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.topic_completion_completion_id_seq', 7, true);


--
-- TOC entry 5160 (class 0 OID 0)
-- Dependencies: 223
-- Name: topics_topic_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.topics_topic_id_seq', 9, true);


--
-- TOC entry 5161 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_user_id_seq', 5, true);


--
-- TOC entry 4950 (class 2606 OID 24782)
-- Name: attempt_answers attempt_answers_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attempt_answers
    ADD CONSTRAINT attempt_answers_pkey PRIMARY KEY (answer_id);


--
-- TOC entry 4944 (class 2606 OID 24730)
-- Name: learning_progress learning_progress_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.learning_progress
    ADD CONSTRAINT learning_progress_pkey PRIMARY KEY (progress_id);


--
-- TOC entry 4954 (class 2606 OID 32920)
-- Name: lesson_sections lesson_sections_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lesson_sections
    ADD CONSTRAINT lesson_sections_pkey PRIMARY KEY (section_id);


--
-- TOC entry 4942 (class 2606 OID 24716)
-- Name: notes notes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notes
    ADD CONSTRAINT notes_pkey PRIMARY KEY (note_id);


--
-- TOC entry 4946 (class 2606 OID 24750)
-- Name: questions questions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (question_id);


--
-- TOC entry 4948 (class 2606 OID 24764)
-- Name: quiz_attempt quiz_attempt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.quiz_attempt
    ADD CONSTRAINT quiz_attempt_pkey PRIMARY KEY (attempt_id);


--
-- TOC entry 4956 (class 2606 OID 32942)
-- Name: subject_diagnostic subject_diagnostic_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subject_diagnostic
    ADD CONSTRAINT subject_diagnostic_pkey PRIMARY KEY (diagnostic_id);


--
-- TOC entry 4938 (class 2606 OID 24693)
-- Name: subjects subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_pkey PRIMARY KEY (subject_id);


--
-- TOC entry 4952 (class 2606 OID 32910)
-- Name: topic_completion topic_completion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.topic_completion
    ADD CONSTRAINT topic_completion_pkey PRIMARY KEY (completion_id);


--
-- TOC entry 4940 (class 2606 OID 24701)
-- Name: topics topics_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.topics
    ADD CONSTRAINT topics_pkey PRIMARY KEY (topic_id);


--
-- TOC entry 4934 (class 2606 OID 24685)
-- Name: users users_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);


--
-- TOC entry 4936 (class 2606 OID 24683)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- TOC entry 4964 (class 2606 OID 24783)
-- Name: attempt_answers attempt_answers_attempt_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attempt_answers
    ADD CONSTRAINT attempt_answers_attempt_id_fkey FOREIGN KEY (attempt_id) REFERENCES public.quiz_attempt(attempt_id) ON DELETE CASCADE;


--
-- TOC entry 4965 (class 2606 OID 24788)
-- Name: attempt_answers attempt_answers_question_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.attempt_answers
    ADD CONSTRAINT attempt_answers_question_id_fkey FOREIGN KEY (question_id) REFERENCES public.questions(question_id);


--
-- TOC entry 4959 (class 2606 OID 24736)
-- Name: learning_progress learning_progress_topic_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.learning_progress
    ADD CONSTRAINT learning_progress_topic_id_fkey FOREIGN KEY (topic_id) REFERENCES public.topics(topic_id) ON DELETE CASCADE;


--
-- TOC entry 4960 (class 2606 OID 24731)
-- Name: learning_progress learning_progress_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.learning_progress
    ADD CONSTRAINT learning_progress_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id) ON DELETE CASCADE;


--
-- TOC entry 4958 (class 2606 OID 24717)
-- Name: notes notes_topic_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.notes
    ADD CONSTRAINT notes_topic_id_fkey FOREIGN KEY (topic_id) REFERENCES public.topics(topic_id) ON DELETE CASCADE;


--
-- TOC entry 4961 (class 2606 OID 24751)
-- Name: questions questions_topic_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_topic_id_fkey FOREIGN KEY (topic_id) REFERENCES public.topics(topic_id) ON DELETE CASCADE;


--
-- TOC entry 4962 (class 2606 OID 24770)
-- Name: quiz_attempt quiz_attempt_topic_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.quiz_attempt
    ADD CONSTRAINT quiz_attempt_topic_id_fkey FOREIGN KEY (topic_id) REFERENCES public.topics(topic_id);


--
-- TOC entry 4963 (class 2606 OID 24765)
-- Name: quiz_attempt quiz_attempt_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.quiz_attempt
    ADD CONSTRAINT quiz_attempt_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id);


--
-- TOC entry 4957 (class 2606 OID 24702)
-- Name: topics topics_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.topics
    ADD CONSTRAINT topics_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(subject_id) ON DELETE CASCADE;


-- Completed on 2026-06-21 01:22:40

--
-- PostgreSQL database dump complete
--

\unrestrict E2Kn8dl8nFqNTT7CkZRb9fmKWyp2hZfAwya9eaCNCPSgYd13fFEHKdeicMHHPGf

